<?php
/************************************************************
 * This plugin was modified by Revmakx						*
 * Copyright (c) 2012 Revmakx								*
 * www.revmakx.com											*
 *															*
 ************************************************************/
/*************************************************************
 * 
 * backup.class.php
 * 
 * Manage Backups
 * 
 * 
 * Copyright (c) 2011 Prelovac Media
 * www.prelovac.com
 **************************************************************/
define('IWP_BACKUP_DIR', WP_CONTENT_DIR . '/infinitewp/backups');
define('IWP_DB_DIR', IWP_BACKUP_DIR . '/iwp_db');

$zip_errors   = array(
    'No error',
    'No error',
    'Unexpected end of zip file',
    'A generic error in the zipfile format was detected.',
    'zip was unable to allocate itself memory',
    'A severe error in the zipfile format was detected',
    'Entry too large to be split with zipsplit',
    'Invalid comment format',
    'zip -T failed or out of memory',
    'The user aborted zip prematurely',
    'zip encountered an error while using a temp file',
    'Read or seek error',
    'zip has nothing to do',
    'Missing or empty zip file',
    'Error writing to a file',
    'zip was unable to create a file to write to',
    'bad command line parameters',
    'no error',
    'zip could not open a specified file to read'
);
$unzip_errors = array(
    'No error',
    'One or more warning errors were encountered, but processing completed successfully anyway',
    'A generic error in the zipfile format was detected',
    'A severe error in the zipfile format was detected.',
    'unzip was unable to allocate itself memory.',
    'unzip was unable to allocate memory, or encountered an encryption error',
    'unzip was unable to allocate memory during decompression to disk',
    'unzip was unable allocate memory during in-memory decompression',
    'unused',
    'The specified zipfiles were not found',
    'Bad command line parameters',
    'No matching files were found',
    50 => 'The disk is (or was) full during extraction',
    51 => 'The end of the ZIP archive was encountered prematurely.',
    80 => 'The user aborted unzip prematurely.',
    81 => 'Testing or extraction of one or more files failed due to unsupported compression methods or unsupported decryption.',
    82 => 'No files were found due to bad decryption password(s)'
);


class IWP_MMB_Backup extends IWP_MMB_Core
{
    var $site_name;
    var $statuses;
    var $tasks;
    var $s3;
    var $ftp;
    var $dropbox;
    function __construct()
    {
        parent::__construct();
        $this->site_name = str_replace(array(
            "_",
            "/",
	    			"~"
        ), array(
            "",
            "-",
            "-"
        ), rtrim($this->remove_http(get_bloginfo('url')), "/"));
        $this->statuses  = array(
            'db_dump' => 1,
            'db_zip' => 2,
            'files_zip' => 3,
            'finished' => 100
        );
        $this->tasks     = get_option('iwp_client_backup_tasks');
    }
    
    function get_backup_settings()
    {
        $backup_settings = get_option('iwp_client_backup_tasks');
        if (!empty($backup_settings))
            return $backup_settings;
        else
            return false;
    }
    
    function set_backup_task($params)
    {
        //$params => [$task_name, $args, $error]
        if (!empty($params)) {
        	
        	//Make sure backup cron job is set
        if (!wp_next_scheduled('iwp_client_backup_tasks')) {
					wp_schedule_event( time(), 'tenminutes', 'iwp_client_backup_tasks' );
				}
        	
            extract($params);
            
            //$before = $this->get_backup_settings();
            $before = $this->tasks;
            if (!$before || empty($before))
                $before = array();
            
            if (isset($args['remove'])) {
                unset($before[$task_name]);
                $return = array(
                    'removed' => true
                );
            } else {
        
                $before[$task_name]['task_args'] = $args;
                $return = $before[$task_name];
            }
            
            //Update with error
            if (isset($error)) {
                if (is_array($error)) {
                    $before[$task_name]['task_results'][count($before[$task_name]['task_results']) - 1]['error'] = $error['error'];
                } else {
                    $before[$task_name]['task_results'][count($before[$task_name]['task_results'])]['error'] = $error;
                }
            }
            
            if ($time) { //set next result time before backup
                if (is_array($before[$task_name]['task_results'])) {
                    $before[$task_name]['task_results'] = array_values($before[$task_name]['task_results']);
                }
                $before[$task_name]['task_results'][count($before[$task_name]['task_results'])]['time'] = $time;
            }
            
            $this->update_tasks($before);
            //update_option('iwp_client_backup_tasks', $before);
            
            if ($task_name == 'Backup Now') {
                $result          = $this->backup($args, $task_name);
                $backup_settings = $this->tasks;
                
                if (is_array($result) && array_key_exists('error', $result)) {
                    $return = $result;
                } else {
                    $return = $backup_settings[$task_name];
                }
            }
            return $return;
        }
        
        
				
        return false;
    }
    
    //Cron check
    function check_backup_tasks()
    {
    	
    		$this->check_cron_remove();
        
        $settings = $this->tasks;
        if (is_array($settings) && !empty($settings)) {
            foreach ($settings as $task_name => $setting) {

                if ($setting['task_args']['next'] && $setting['task_args']['next'] < time()) {
                    //if ($setting['task_args']['next'] && $_GET['force_backup']) {
                    if ($setting['task_args']['url'] && $setting['task_args']['task_id'] && $setting['task_args']['site_key']) {
                        //Check orphan task
                        $check_data = array(
                            'task_name' => $task_name,
                            'task_id' => $setting['task_args']['task_id'],
                            'site_key' => $setting['task_args']['site_key']
                        );
                        
                        $check = $this->validate_task($check_data, $setting['task_args']['url']);
                        
                    }

                    $update = array(
                        'task_name' => $task_name,
                        'args' => $settings[$task_name]['task_args']  
                    );
                    
                    
                    if($check != 'paused'){
                    	$update['time'] = time();
                    }
                    
                    //Update task with next schedule
                    $this->set_backup_task($update);
                    
                    if($check == 'paused'){
                    	continue;
                    }
                    
                    
                    $result = $this->backup($setting['task_args'], $task_name);
                    $error  = '';
                    if (is_array($result) && array_key_exists('error', $result)) {
                        $error = $result;
                        $this->set_backup_task(array(
                            'task_name' => $task_name,
                            'args' => $settings[$task_name]['task_args'],
                            'error' => $error
                        ));
                    } else {
                        $error = '';
                    }
                    break; //Only one backup per cron
                }
            }
        }
        
    }
    
    /*
     * If Task Name not set then it's manual backup
     * Backup args:
     * type -> db, full
     * what -> daily, weekly, monthly
     * account_info -> ftp, amazons3, dropbox
     * exclude-> array of paths to exclude from backup
     */
    
    function backup($args, $task_name = false)
    {
        if (!$args || empty($args))
            return false;
        
        extract($args); //extract settings
        
        //Try increase memory limit	and execution time
        @ini_set('memory_limit', '256M');
        @set_time_limit(1200); //20 mins
        
        //Remove old backup(s)
        $this->remove_old_backups($task_name);
        
        $new_file_path = IWP_BACKUP_DIR;
        
        if (!file_exists($new_file_path)) {
            if (!mkdir($new_file_path, 0755, true))
                return array(
                    'error' => 'Permission denied, make sure you have write permission to wp-content folder.'
                );
        }
        
        @file_put_contents($new_file_path . '/index.php', ''); //safe
           
        //Prepare .zip file name  
        $hash        = md5(time());
        $label       = $type ? $type : 'manual';
        $backup_file = $new_file_path . '/' . $this->site_name . '_' . $label . '_' . $what . '_' . date('Y-m-d') . '_' . $hash . '.zip';
        $backup_url  = WP_CONTENT_URL . '/infinitewp/backups/' . $this->site_name . '_' . $label . '_' . $what . '_' . date('Y-m-d') . '_' . $hash . '.zip';
        
        //Optimize tables?
        if (isset($optimize_tables) && !empty($optimize_tables)) {
            $this->optimize_tables();
        }
        
        //What to backup - db or full?
        if (trim($what) == 'db') {
            //Take database backup
            $this->update_status($task_name, $this->statuses['db_dump']);
            $db_result = $this->backup_db();
            if ($db_result == false) {
                return array(
                    'error' => 'Failed to backup database.'
                );
            } else if (is_array($db_result) && isset($db_result['error'])) {
                return array(
                    'error' => $db_result['error']
                );
            } else {
                $this->update_status($task_name, $this->statuses['db_dump'], true);
                $this->update_status($task_name, $this->statuses['db_zip']);
                
                $disable_comp = $this->tasks[$task_name]['task_args']['disable_comp'];
                $comp_level   = $disable_comp ? '-0' : '-1';
                
                chdir(IWP_BACKUP_DIR);
                $zip     = $this->get_zip();
                $command = "$zip -q -r $comp_level $backup_file 'iwp_db'";
                ob_start();
                $result = $this->iwp_mmb_exec($command);
                ob_get_clean();
                if (!$result) { // fallback to pclzip
                    define('PCLZIP_TEMPORARY_DIR', IWP_BACKUP_DIR . '/');
                    require_once ABSPATH . '/wp-admin/includes/class-pclzip.php';
                    $archive = new PclZip($backup_file);
                    if ($disable_comp) {
                        $result = $archive->add($db_result, PCLZIP_OPT_REMOVE_PATH, IWP_BACKUP_DIR, PCLZIP_OPT_NO_COMPRESSION);
						
                    } else {
                        $result = $archive->add($db_result, PCLZIP_OPT_REMOVE_PATH, IWP_BACKUP_DIR);
                    }
                    @unlink($db_result);
                    @rmdir(IWP_DB_DIR);
                    if (!$result) {
                        return array(
                            'error' => 'Failed to zip database (pclZip - ' . $archive->error_code . '): .' . $archive->error_string
                        );
                    }
                }
                
                @unlink($db_result);
                @rmdir(IWP_DB_DIR);
                if (!$result) {
                    return array(
                        'error' => 'Failed to zip database.'
                    );
                }
                $this->update_status($task_name, $this->statuses['db_zip'], true);
            }
        } elseif (trim($what) == 'full') {
            $content_backup = $this->backup_full($task_name, $backup_file, $exclude, $include);
            if (is_array($content_backup) && array_key_exists('error', $content_backup)) {
                return array(
                    'error' => $content_backup['error']
                );
            }
        }
        
        //Update backup info
        if ($task_name) {
            //backup task (scheduled)
            $backup_settings = $this->tasks;
            $paths           = array();
            $size            = round(filesize($backup_file) / 1024, 2);
            
            if ($size > 1000) {
                $paths['size'] = round($size / 1024, 2) . " MB";//Modified by IWP //Mb => MB
            } else {
                $paths['size'] = $size . 'KB';//Modified by IWP //Kb => KB
            }
			
			$paths['backup_name'] = $backup_settings[$task_name]['task_args']['backup_name'];
            
            if ($task_name != 'Backup Now') {
                if (!$backup_settings[$task_name]['task_args']['del_host_file']) {
                    $paths['server'] = array(
                        'file_path' => $backup_file,
                        'file_url' => $backup_url
                    );
                }
            } else {
                $paths['server'] = array(
                    'file_path' => $backup_file,
                    'file_url' => $backup_url
                );
            }
             
            $temp          = $backup_settings[$task_name]['task_results'];
            $temp          = @array_values($temp);
            $paths['time'] = time();
			
        
            if ($task_name != 'Backup Now') {
                $paths['status']        = $temp[count($temp) - 1]['status'];
                $temp[count($temp) - 1] = $paths;
                
            } else {
                $temp[count($temp)] = $paths;
            }
            
            $backup_settings[$task_name]['task_results'] = $temp;
            $this->update_tasks($backup_settings);
            //update_option('iwp_client_backup_tasks', $backup_settings);
        }
        
        //Additional: Email, ftp, amazon_s3, dropbox...
        
        if ($task_name != 'Backup Now') {
            if ($del_host_file) {
                @unlink($backup_file);
            }
            
        } //end additional
        
        //$this->update_status($task_name,$this->statuses['finished'],true);
        return $backup_url; //Return url to backup file
    }
    
    function backup_full($task_name, $backup_file, $exclude = array(), $include = array())
    {
        global $zip_errors;
        $sys = substr(PHP_OS, 0, 3);
        
        $this->update_status($task_name, $this->statuses['db_dump']);
        $db_result = $this->backup_db();
        
        if ($db_result == false) {
            return array(
                'error' => 'Failed to backup database.'
            );
        } else if (is_array($db_result) && isset($db_result['error'])) {
            return array(
                'error' => $db_result['error']
            );
        }
        
        $this->update_status($task_name, $this->statuses['db_dump'], true);
        $this->update_status($task_name, $this->statuses['db_zip']);
        $disable_comp = $this->tasks[$task_name]['task_args']['disable_comp'];
        $comp_level   = $disable_comp ? '-0' : '-1';
        
        $zip = $this->get_zip();
        //Add database file
        chdir(IWP_BACKUP_DIR);
        $command = "$zip -q -r $comp_level $backup_file 'iwp_db'";
        ob_start();
        $result = $this->iwp_mmb_exec($command);
        ob_get_clean();
        
        
        if (!$result) {
            define('PCLZIP_TEMPORARY_DIR', IWP_BACKUP_DIR . '/');
            require_once ABSPATH . '/wp-admin/includes/class-pclzip.php';
            $archive = new PclZip($backup_file);
            
            if ($disable_comp) {
                $result_db = $archive->add($db_result, PCLZIP_OPT_REMOVE_PATH, IWP_BACKUP_DIR, PCLZIP_OPT_NO_COMPRESSION);
            } else {
                $result_db = $archive->add($db_result, PCLZIP_OPT_REMOVE_PATH, IWP_BACKUP_DIR);
            }
            
            @unlink($db_result);
            @rmdir(IWP_DB_DIR);
            
            if (!$result_db) {
                return array(
                    'error' => 'Failed to zip database. pclZip error (' . $archive->error_code . '): .' . $archive->error_string
                );
            }
        }
        
        @unlink($db_result);
        @rmdir(IWP_DB_DIR);
        
        $this->update_status($task_name, $this->statuses['db_zip'], true);
        
        
        //Always remove backup folders    
        $remove = array(
            trim(basename(WP_CONTENT_DIR)) . "/infinitewp/backups",
            trim(basename(WP_CONTENT_DIR)) . "/" . md5('iwp_mmb-client') . "/iwp_backups"
        );
        
        //Exclude paths
        $exclude_data = "-x";
        
        $exclude_file_data = '';
        
        if (!empty($exclude)) {
            foreach ($exclude as $data) {
                if (is_dir(ABSPATH . $data)) {
                    if ($sys == 'WIN')
                        $exclude_data .= " $data/*.*";
                    else
                        $exclude_data .= " $data/*";
                        
                        
                } else {
                    if ($sys == 'WIN'){
                    	if(file_exists(ABSPATH . $data)){
                        $exclude_data .= " $data";
                        	$exclude_file_data .= " $data";
                        }
                      } else {
                    			if(file_exists(ABSPATH . $data)){
                        $exclude_data .= " '$data'";
                        		$exclude_file_data .= " '$data'";
                }
            }
        }
            }
        }
        
        if($exclude_file_data){
        	$exclude_file_data = "-x".$exclude_file_data;
        }
        
        foreach ($remove as $data) {
            if ($sys == 'WIN')
                $exclude_data .= " $data/*.*";
            else
                $exclude_data .= " '$data/*'";
        }
        
        //Include paths by default
        $add = array(
            trim(WPINC),
            trim(basename(WP_CONTENT_DIR)),
            "wp-admin"
        );
        
        $include_data = ". -i";
        foreach ($add as $data) {
            if ($sys == 'WIN')
                $include_data .= " $data/*.*";
            else
                $include_data .= " '$data/*'";
        }
        
        //Additional includes?
        if (!empty($include)) {
            foreach ($include as $data) {
                if ($data) {
                    if ($sys == 'WIN')
                        $include_data .= " $data/*.*";
                    else
                        $include_data .= " '$data/*'";
                }
            }
        }
        
        $this->update_status($task_name, $this->statuses['files_zip']);
        chdir(ABSPATH);
        ob_start();
        $command  = "$zip -q -j $comp_level $backup_file .* * $exclude_data";
        $result_f = $this->iwp_mmb_exec($command, false, true);
        if (!$result_f || $result_f == 18) { // disregard permissions error, file can't be accessed
            $command  = "$zip -q -r $comp_level $backup_file $include_data $exclude_data";
            $result_d = $this->iwp_mmb_exec($command, false, true);            
            if ($result_d && $result_d != 18) {
                @unlink($backup_file);
                if ($result_d > 0 && $result_d < 18)
                    return array(
                        'error' => 'Failed to archive files (' . $zip_errors[$result_d] . ') .'
                    );
                else
                    return array(
                        'error' => 'Failed to archive files.'
                    );
            }
        }
        ob_get_clean();
        
        if ($result_f && $result_f != 18) { //Try pclZip
            
            if (!isset($archive)) {
                define('PCLZIP_TEMPORARY_DIR', IWP_BACKUP_DIR . '/');
                require_once ABSPATH . '/wp-admin/includes/class-pclzip.php';
                $archive = new PclZip($backup_file);
            }
            
            //Include paths
            $include_data = array();
            if (!empty($include)) {
                foreach ($include as $data) {
                    if ($data && file_exists(ABSPATH . $data))
                        $include_data[] = ABSPATH . $data . '/';
                }
            }
            
            foreach ($add as $data) {
                if (file_exists(ABSPATH . $data))
                    $include_data[] = ABSPATH . $data . '/';
            }
            
            //Include root files
            if ($handle = opendir(ABSPATH)) {
                while (false !== ($file = readdir($handle))) {
                    if ($file != "." && $file != ".." && !is_dir($file) && file_exists(ABSPATH . $file)) {
                        $include_data[] = ABSPATH . $file;
                    }
                }
                closedir($handle);
            }
            
            if ($disable_comp) {
                $result = $archive->add($include_data, PCLZIP_OPT_REMOVE_PATH, ABSPATH, PCLZIP_OPT_NO_COMPRESSION);
            } else {
                $result = $archive->add($include_data, PCLZIP_OPT_REMOVE_PATH, ABSPATH);
            }
            if (!$result) {
                @unlink($backup_file);
                return array(
                    'error' => 'Failed to zip files. pclZip error (' . $archive->error_code . '): .' . $archive->error_string
                );
            }
            
            //Now exclude paths
            $exclude_data = array();
            if (!empty($exclude)) {
                foreach ($exclude as $data) {
                    if (is_dir(ABSPATH . $data))
                        $exclude_data[] = $data . '/';
                    else
                        $exclude_data[] = $data;
                }
            }
            
            foreach ($remove as $rem) {
                $exclude_data[] = $rem . '/';
            }
            
            $result_excl = $archive->delete(PCLZIP_OPT_BY_NAME, $exclude_data);
            if (!$result_excl) {
                @unlink($backup_file);
                return array(
                    'error' => 'Failed to zip files. pclZip error (' . $archive->error_code . '): .' . $archive->error_string
                );
            }
        }
        
        //Reconnect
        $this->wpdb_reconnect();
        
        $this->update_status($task_name, $this->statuses['files_zip'], true);
        return true;
    }
    
    
    function backup_db()
    {
        $db_folder = IWP_DB_DIR . '/';
        if (!file_exists($db_folder)) {
            if (!mkdir($db_folder, 0755, true))
                return array(
                    'error' => 'Error creating database backup folder (' . $db_folder . '). Make sure you have corrrect write permissions.'
                );
        }
        
        $file   = $db_folder . DB_NAME . '.sql';
        $result = $this->backup_db_dump($file); // try mysqldump always then fallback to php dump
        return $result;
    }
    
    function backup_db_dump($file)
    {
        global $wpdb;
        $paths   = $this->check_mysql_paths();
        $brace   = (substr(PHP_OS, 0, 3) == 'WIN') ? '"' : '';
        $command = $brace . $paths['mysqldump'] . $brace . ' --host="' . DB_HOST . '" --user="' . DB_USER . '" --password="' . DB_PASSWORD . '" --add-drop-table --skip-lock-tables "' . DB_NAME . '" > ' . $brace . $file . $brace;
        ob_start();
        $result = $this->iwp_mmb_exec($command);
        ob_get_clean();
        
        if (!$result) { // Fallback to php
            $result = $this->backup_db_php($file);
            return $result;
        }
        
        if (filesize($file) == 0 || !is_file($file) || !$result) {
            @unlink($file);
            return false;
        } else {
            return $file;
        }
    }
    
    function backup_db_php($file)
    {
        global $wpdb;
        $tables = $wpdb->get_results('SHOW TABLES', ARRAY_N);
        foreach ($tables as $table) {
            //drop existing table
            $dump_data    = "DROP TABLE IF EXISTS $table[0];";
            //create table
            $create_table = $wpdb->get_row("SHOW CREATE TABLE $table[0]", ARRAY_N);
            $dump_data .= "\n\n" . $create_table[1] . ";\n\n";
            
            $count = $wpdb->get_var("SELECT count(*) FROM $table[0]");
            if ($count > 100)
                $count = ceil($count / 100);
            else if ($count > 0)            
                $count = 1;                
                
            for ($i = 0; $i < $count; $i++) {
                $low_limit = $i * 100;
                $qry       = "SELECT * FROM $table[0] LIMIT $low_limit, 100";
                $rows      = $wpdb->get_results($qry, ARRAY_A);
                if (is_array($rows)) {
                    foreach ($rows as $row) {
                        //insert single row
                        $dump_data .= "INSERT INTO $table[0] VALUES(";
                        $num_values = count($row);
                        $j          = 1;
                        foreach ($row as $value) {
                            $value = addslashes($value);
                            $value = preg_replace("/\n/Ui", "\\n", $value);
                            $num_values == $j ? $dump_data .= "'" . $value . "'" : $dump_data .= "'" . $value . "', ";
                            $j++;
                            unset($value);
                        }
                        $dump_data .= ");\n";
                    }
                }
            }
            $dump_data .= "\n\n\n";
            
            unset($rows);
            file_put_contents($file, $dump_data, FILE_APPEND);
            unset($dump_data);
        }
        
        if (filesize($file) == 0 || !is_file($file)) {
            @unlink($file);
            return array(
                'error' => 'Database backup failed. Try to enable MySQL dump on your server.'
            );
        }
        
        return $file;
        
    }
    
    function restore($args)
    {
        global $wpdb;
        if (empty($args)) {
            return false;
        }
        
        extract($args);
        @ini_set('memory_limit', '256M');
        @set_time_limit(1200);
        
        $unlink_file = true; //Delete file after restore
        
        //Detect source
        if ($backup_url) {
            //This is for clone (overwrite)
            include_once ABSPATH . 'wp-admin/includes/file.php';
            $backup_file = download_url($backup_url);
            if (is_wp_error($backup_file)) {
                return array(
                    'error' => 'Unable to download backup file ('.$backup_file->get_error_message().')'
                );
            }
            $what = 'full';
        } else {
            $tasks = $this->tasks;
            $task  = $tasks[$task_name];
            if (isset($task['task_results'][$result_id]['server'])) {
                $backup_file = $task['task_results'][$result_id]['server']['file_path'];
                $unlink_file = false; //Don't delete file if stored on server
            } 
            
            $what = $tasks[$task_name]['task_args']['what'];
        }
        
        $this->wpdb_reconnect();
        
        if ($backup_file && file_exists($backup_file)) {
            if ($overwrite) {
                //Keep old db credentials before overwrite
                if (!copy(ABSPATH . 'wp-config.php', ABSPATH . 'iwp-temp-wp-config.php')) {
                    @unlink($backup_file);
                    return array(
                        'error' => 'Error creating wp-config. Please check your write permissions.'
                    );
                }
                
                $db_host     = DB_HOST;
                $db_user     = DB_USER;
                $db_password = DB_PASSWORD;
                $home        = rtrim(get_option('home'), "/");
                $site_url    = get_option('site_url');
                
                $clone_options                       = array();
                if (trim($clone_from_url) || trim($iwp_clone)) {
                    
                    $clone_options['iwp_client_nossl_key']  = get_option('iwp_client_nossl_key');
                    $clone_options['iwp_client_public_key'] = get_option('iwp_client_public_key');
                    $clone_options['iwp_client_action_message_id'] = get_option('iwp_client_action_message_id');
                   
                }
                
                 $clone_options['iwp_client_backup_tasks'] = serialize(get_option('iwp_client_backup_tasks'));
                 $clone_options['iwp_client_notifications'] = serialize(get_option('iwp_client_notifications'));
                 $clone_options['iwp_client_pageview_alerts'] = serialize(get_option('iwp_client_pageview_alerts'));
                
                
            } else {
            	$restore_options                       = array();
              $restore_options['iwp_client_notifications'] = get_option('iwp_client_notifications');
              $restore_options['iwp_client_pageview_alerts'] = get_option('iwp_client_pageview_alerts');
              $restore_options['iwp_client_user_hit_count'] = get_option('iwp_client_user_hit_count');
            }
            
            
            chdir(ABSPATH);
            $unzip   = $this->get_unzip();
            $command = "$unzip -o $backup_file";
            ob_start();
            $result = $this->iwp_mmb_exec($command);
            ob_get_clean();
            
            if (!$result) { //fallback to pclzip
                define('PCLZIP_TEMPORARY_DIR', IWP_BACKUP_DIR . '/');
                require_once ABSPATH . '/wp-admin/includes/class-pclzip.php';
                $archive = new PclZip($backup_file);
                $result  = $archive->extract(PCLZIP_OPT_PATH, ABSPATH, PCLZIP_OPT_REPLACE_NEWER);
            }
            
            if ($unlink_file) {
                @unlink($backup_file);
            }
            
            if (!$result) {
                return array(
                    'error' => 'Failed to unzip files. pclZip error (' . $archive->error_code . '): .' . $archive->error_string
                );
            }
            
            $db_result = $this->restore_db(); 
            
           if (!$db_result) {
                return array(
                    'error' => 'Error restoring database.'
                );
            } else if(is_array($db_result) && isset($db_result['error'])){
            		return array(
                    'error' => $db_result['error']
                );
            }
            
        } else {
            return array(
                'error' => 'Error restoring. Cannot find backup file.'
            );
        }
        
        $this->wpdb_reconnect();
        
        //Replace options and content urls
        if ($overwrite) {
            //Get New Table prefix
            $new_table_prefix = trim($this->get_table_prefix());
            //Retrieve old wp_config
            @unlink(ABSPATH . 'wp-config.php');
            //Replace table prefix
            $lines = file(ABSPATH . 'iwp-temp-wp-config.php');
            
            foreach ($lines as $line) {
                if (strstr($line, '$table_prefix')) {
                    $line = '$table_prefix = "' . $new_table_prefix . '";' . PHP_EOL;
                }
                file_put_contents(ABSPATH . 'wp-config.php', $line, FILE_APPEND);
            }
            
            @unlink(ABSPATH . 'iwp-temp-wp-config.php');
            
            //Replace options
            $query = "SELECT option_value FROM " . $new_table_prefix . "options WHERE option_name = 'home'";
            $old   = $wpdb->get_var($wpdb->prepare($query));
            $old   = rtrim($old, "/");
            $query = "UPDATE " . $new_table_prefix . "options SET option_value = '$home' WHERE option_name = 'home'";
            $wpdb->query($wpdb->prepare($query));
            $query = "UPDATE " . $new_table_prefix . "options  SET option_value = '$home' WHERE option_name = 'siteurl'";
            $wpdb->query($wpdb->prepare($query));
            //Replace content urls
            $query = "UPDATE " . $new_table_prefix . "posts SET post_content = REPLACE (post_content, '$old','$home') WHERE post_content REGEXP 'src=\"(.*)$old(.*)\"' OR post_content REGEXP 'href=\"(.*)$old(.*)\"'";
            $wpdb->query($wpdb->prepare($query));
            
            if (trim($new_password)) {
                $new_password = wp_hash_password($new_password);
            }
            if (!trim($clone_from_url) && !trim($iwp_clone)) {
                if ($new_user && $new_password) {
                    $query = "UPDATE " . $new_table_prefix . "users SET user_login = '$new_user', user_pass = '$new_password' WHERE user_login = '$old_user'";
                    $wpdb->query($wpdb->prepare($query));
                }
            } else {
                if ($clone_from_url) {
                    if ($new_user && $new_password) {
                        $query = "UPDATE " . $new_table_prefix . "users SET user_pass = '$new_password' WHERE user_login = '$new_user'";
                        $wpdb->query($wpdb->prepare($query));
                    }
                }
                
                if ($iwp_clone) {
                    if ($admin_email) {
                        //Clean Install
                        $query = "UPDATE " . $new_table_prefix . "options SET option_value = '$admin_email' WHERE option_name = 'admin_email'";
                        $wpdb->query($wpdb->prepare($query));
                        $query     = "SELECT * FROM " . $new_table_prefix . "users LIMIT 1";
                        $temp_user = $wpdb->get_row($query);
                        if (!empty($temp_user)) {
                            $query = "UPDATE " . $new_table_prefix . "users SET user_email='$admin_email', user_login = '$new_user', user_pass = '$new_password' WHERE user_login = '$temp_user->user_login'";
                            $wpdb->query($wpdb->prepare($query));
                        }
                        
                    }
                }
            }
            
            if (is_array($clone_options) && !empty($clone_options)) {
                foreach ($clone_options as $key => $option) {
                    if (!empty($key)) {
                        $query = "SELECT option_value FROM " . $new_table_prefix . "options WHERE option_name = '$key'";
                        $res   = $wpdb->get_var($query);
                        if ($res == false) {
                            $query = "INSERT INTO " . $new_table_prefix . "options  (option_value,option_name) VALUES('$option','$key')";
                            $wpdb->query($wpdb->prepare($query));
                        } else {
                            $query = "UPDATE " . $new_table_prefix . "options  SET option_value = '$option' WHERE option_name = '$key'";
                            $wpdb->query($wpdb->prepare($query));
                        }
                    }
                }
            }
            
            //Remove hit count
            $query = "DELETE FROM " . $new_table_prefix . "options WHERE option_name = 'iwp_client_user_hit_count'";
           	$wpdb->query($wpdb->prepare($query));
            
            //Check for .htaccess permalinks update
            $this->replace_htaccess($home);
        } else {
        			
        			//restore client options
              if (is_array($restore_options) && !empty($restore_options)) {
                foreach ($restore_options as $key => $option) {
                	update_option($key,$option);
                }
              }

        }
        
        
        
        
        return true;
    }
    
    function restore_db()
    {
        global $wpdb;
        $paths     = $this->check_mysql_paths();
        $file_path = ABSPATH . 'iwp_db';
        @chmod($file_path,0755);
        $file_name = glob($file_path . '/*.sql');
        $file_name = $file_name[0];
        
        if(!$file_name){
        	return array('error' => 'Cannot access database file.');
        }
        
        $brace     = (substr(PHP_OS, 0, 3) == 'WIN') ? '"' : '';
        $command   = $brace . $paths['mysql'] . $brace . ' --host="' . DB_HOST . '" --user="' . DB_USER . '" --password="' . DB_PASSWORD . '" ' . DB_NAME . ' < ' . $brace . $file_name . $brace;
        
        ob_start();
        $result = $this->iwp_mmb_exec($command);
        ob_get_clean();
        if (!$result) {
            //try php
            $this->restore_db_php($file_name);
        }
        
        
        @unlink($file_name);
        return true;
    }
    
    function restore_db_php($file_name)
    {
        global $wpdb;
        $current_query = '';
        // Read in entire file
        $lines         = file($file_name);
        // Loop through each line
        foreach ($lines as $line) {
            // Skip it if it's a comment
            if (substr($line, 0, 2) == '--' || $line == '')
                continue;
            
            // Add this line to the current query
            $current_query .= $line;
            // If it has a semicolon at the end, it's the end of the query
            if (substr(trim($line), -1, 1) == ';') {
                // Perform the query
                $result = $wpdb->query($current_query);
                if ($result === false)
                    return false;
                // Reset temp variable to empty
                $current_query = '';
            }
        }
        
        @unlink($file_name);
        return true;
    }
    
    function get_table_prefix()
    {
        $lines = file(ABSPATH . 'wp-config.php');
        foreach ($lines as $line) {
            if (strstr($line, '$table_prefix')) {
                $pattern = "/(\'|\")[^(\'|\")]*/";
                preg_match($pattern, $line, $matches);
                $prefix = substr($matches[0], 1);
                return $prefix;
                break;
            }
        }
        return 'wp_'; //default
    }
    
    function optimize_tables()
    {
        global $wpdb;
        $query  = 'SHOW TABLE STATUS FROM ' . DB_NAME;
        $tables = $wpdb->get_results($wpdb->prepare($query), ARRAY_A);
        foreach ($tables as $table) {
            if (in_array($table['Engine'], array(
                'MyISAM',
                'ISAM',
                'HEAP',
                'MEMORY',
                'ARCHIVE'
            )))
                $table_string .= $table['Name'] . ",";
            elseif ($table['Engine'] == 'InnoDB') {
                $optimize = $wpdb->query("ALTER TABLE {$table['Name']} ENGINE=InnoDB");
            }
        }
        
        $table_string = rtrim($table_string);
        $optimize     = $wpdb->query("OPTIMIZE TABLE $table_string");
        
        return $optimize ? true : false;
    }
    
    ### Function: Auto Detect MYSQL and MYSQL Dump Paths
    function check_mysql_paths()
    {
        global $wpdb;
        $paths = array(
            'mysql' => '',
            'mysqldump' => ''
        );
        if (substr(PHP_OS, 0, 3) == 'WIN') {
            $mysql_install = $wpdb->get_row("SHOW VARIABLES LIKE 'basedir'");
            if ($mysql_install) {
                $install_path       = str_replace('\\', '/', $mysql_install->Value);
                $paths['mysql']     = $install_path . 'bin/mysql.exe';
                $paths['mysqldump'] = $install_path . 'bin/mysqldump.exe';
            } else {
                $paths['mysql']     = 'mysql.exe';
                $paths['mysqldump'] = 'mysqldump.exe';
            }
        } else {
            $paths['mysql'] = $this->iwp_mmb_exec('which mysql', true);
            if (empty($paths['mysql']))
                $paths['mysql'] = 'mysql'; // try anyway
            
            $paths['mysqldump'] = $this->iwp_mmb_exec('which mysqldump', true);
            if (empty($paths['mysqldump']))
                $paths['mysqldump'] = 'mysqldump'; // try anyway         
            
        }
        
        
        return $paths;
    }
    
    //Check if exec, system, passthru functions exist
    function check_sys()
    {
        if ($this->iwp_mmb_function_exists('exec'))
            return 'exec';
        
        if ($this->iwp_mmb_function_exists('system'))
            return 'system';
        
        if ($this->iwp_mmb_function_exists('passhtru'))
            return 'passthru';
        
        return false;
        
    }
    
    function iwp_mmb_exec($command, $string = false, $rawreturn = false)
    {
        if ($command == '')
            return false;
        
        if ($this->iwp_mmb_function_exists('exec')) {
            $log = @exec($command, $output, $return);
            
            if ($string)
                return $log;
            if ($rawreturn)
                return $return;
            
            return $return ? false : true;
        } elseif ($this->iwp_mmb_function_exists('system')) {
            $log = @system($command, $return);
            
            if ($string)
                return $log;
            
            if ($rawreturn)
                return $return;
            
            return $return ? false : true;
        } elseif ($this->iwp_mmb_function_exists('passthru') && !$string) {
            $log = passthru($command, $return);
            
            if ($rawreturn)
                return $return;
            
            return $return ? false : true;
        }
        
        if ($rawreturn)
        	return -1;
        	
        return false;
    }
    
    function get_zip()
    {
        $zip = $this->iwp_mmb_exec('which zip', true);
        if (!$zip)
            $zip = "zip";
        return $zip;
    }
    
    function get_unzip()
    {
        $unzip = $this->iwp_mmb_exec('which unzip', true);
        if (!$unzip)
            $unzip = "unzip";
        return $unzip;
    }
    
    function check_backup_compat()
    {
        $reqs = array();
        if (strpos($_SERVER['DOCUMENT_ROOT'], '/') === 0) {
            $reqs['Server OS']['status'] = 'Linux (or compatible)';
            $reqs['Server OS']['pass']   = true;
        } else {
            $reqs['Server OS']['status'] = 'Windows';
            $reqs['Server OS']['pass']   = true;
            $pass                        = false;
        }
        $reqs['PHP Version']['status'] = phpversion();
        if ((float) phpversion() >= 5.1) {
            $reqs['PHP Version']['pass'] = true;
        } else {
            $reqs['PHP Version']['pass'] = false;
            $pass                        = false;
        }
        
        
        if (is_writable(WP_CONTENT_DIR)) {
            $reqs['Backup Folder']['status'] = "writable";
            $reqs['Backup Folder']['pass']   = true;
        } else {
            $reqs['Backup Folder']['status'] = "not writable";
            $reqs['Backup Folder']['pass']   = false;
        }
        
        
        $file_path = IWP_BACKUP_DIR;
        $reqs['Backup Folder']['status'] .= ' (' . $file_path . ')';
        
        if ($func = $this->check_sys()) {
            $reqs['Execute Function']['status'] = $func;
            $reqs['Execute Function']['pass']   = true;
        } else {
            $reqs['Execute Function']['status'] = "not found";
            $reqs['Execute Function']['info']   = "(will try PHP replacement)";
            $reqs['Execute Function']['pass']   = false;
        }
        $reqs['Zip']['status'] = $this->get_zip();
        
        $reqs['Zip']['pass'] = true;
        
        
        
        $reqs['Unzip']['status'] = $this->get_unzip();
        
        $reqs['Unzip']['pass'] = true;
        
        $paths = $this->check_mysql_paths();
        
        if (!empty($paths['mysqldump'])) {
            $reqs['MySQL Dump']['status'] = $paths['mysqldump'];
            $reqs['MySQL Dump']['pass']   = true;
        } else {
            $reqs['MySQL Dump']['status'] = "not found";
            $reqs['MySQL Dump']['info']   = "(will try PHP replacement)";
            $reqs['MySQL Dump']['pass']   = false;
        }
        
        $exec_time                        = ini_get('max_execution_time');
        $reqs['Execution time']['status'] = $exec_time ? $exec_time . "s" : 'unknown';
        $reqs['Execution time']['pass']   = true;
        
        $mem_limit                      = ini_get('memory_limit');
        $reqs['Memory limit']['status'] = $mem_limit ? $mem_limit : 'unknown';
        $reqs['Memory limit']['pass']   = true;
        
        
        return $reqs;
    }
        
    //Parse task arguments for info on IWP Admin Panel
    function get_backup_stats()
    {
        $stats = array();
        $tasks = $this->tasks;
        if (is_array($tasks) && !empty($tasks)) {
            foreach ($tasks as $task_name => $info) {
                if (is_array($info['task_results']) && !empty($info['task_results'])) {
                    foreach ($info['task_results'] as $key => $result) {
                        if (isset($result['server']) && !isset($result['error'])) {
                            if (!file_exists($result['server']['file_path'])) {
                                $info['task_results'][$key]['error'] = 'Backup created but manually removed from server.';
                            }
                        }
                    }
                }
                if (is_array($info['task_results']))
                	$stats[$task_name] = array_values($info['task_results']);
                
            }
        }
        return $stats;
    }
        
    function remove_old_backups($task_name)
    {
        //Check for previous failed backups first
        $this->cleanup();
        
        //Remove by limit
        $backups = $this->tasks;
        if ($task_name == 'Backup Now') {
            $num = 0;
        } else {
            $num = 1;
        }
        
        
        if ((count($backups[$task_name]['task_results']) - $num) >= $backups[$task_name]['task_args']['limit']) {
            //how many to remove ?
            $remove_num = (count($backups[$task_name]['task_results']) - $num - $backups[$task_name]['task_args']['limit']) + 1;
            for ($i = 0; $i < $remove_num; $i++) {
                //Remove from the server
                if (isset($backups[$task_name]['task_results'][$i]['server'])) {
                    @unlink($backups[$task_name]['task_results'][$i]['server']['file_path']);
                }
   
                //Remove database backup info
                unset($backups[$task_name]['task_results'][$i]);
                
            } //end foreach
            
            if (is_array($backups[$task_name]['task_results']))
            	$backups[$task_name]['task_results'] = array_values($backups[$task_name]['task_results']);
            else
            	$backups[$task_name]['task_results']=array();
            	
            $this->update_tasks($backups);
            //update_option('iwp_client_backup_tasks', $backups);
        }
    }
    
    /**
     * Delete specified backup
     * Args: $task_name, $result_id
     */
    
    function delete_backup($args)
    {
        if (empty($args))
            return false;
        extract($args);
        
        $tasks   = $this->tasks;
        $task    = $tasks[$task_name];
        $backups = $task['task_results'];
        $backup  = $backups[$result_id];
        
        if (isset($backup['server'])) {
            @unlink($backup['server']['file_path']);
        }        
        unset($backups[$result_id]);
        
        if (count($backups)) {
            $tasks[$task_name]['task_results'] = $backups;
        } else {
            unset($tasks[$task_name]['task_results']);
        }
        
        $this->update_tasks($tasks);
        //update_option('iwp_client_backup_tasks', $tasks);
        return true;
        
    }
    
    function cleanup()
    {
        $tasks             = $this->tasks;
        $backup_folder     = WP_CONTENT_DIR . '/' . md5('iwp_mmb-client') . '/iwp_backups/';
        $backup_folder_new = IWP_BACKUP_DIR . '/';
        $files             = glob($backup_folder . "*");
        $new               = glob($backup_folder_new . "*");
        
        //Failed db files first
        $db_folder = IWP_DB_DIR . '/';
        $db_files  = glob($db_folder . "*");
        if (is_array($db_files) && !empty($db_files)) {
            foreach ($db_files as $file) {
                @unlink($file);
            }
            @rmdir(IWP_DB_DIR);
        }
        
        
        //clean_old folder?
        if ((basename($files[0]) == 'index.php' && count($files) == 1) || (empty($files))) {
            foreach ($files as $file) {
                @unlink($file);
            }
            @rmdir(WP_CONTENT_DIR . '/' . md5('iwp_mmb-client') . '/iwp_backups');
            @rmdir(WP_CONTENT_DIR . '/' . md5('iwp_mmb-client'));
        }
        
        
        foreach ($new as $b) {
            $files[] = $b;
        }
        $deleted = array();
        
        if (is_array($files) && count($files)) {
            $results = array();
            if (!empty($tasks)) {
                foreach ((array) $tasks as $task) {
                    if (isset($task['task_results']) && count($task['task_results'])) {
                        foreach ($task['task_results'] as $backup) {
                            if (isset($backup['server'])) {
                                $results[] = $backup['server']['file_path'];
                            }
                        }
                    }
                }
            }
            
            $num_deleted = 0;
            foreach ($files as $file) {
                if (!in_array($file, $results) && basename($file) != 'index.php') {
                    @unlink($file);
                    $deleted[] = basename($file);
                    $num_deleted++;
                }
            }
        }
        
        
        
        return $deleted;
    }
    
    
/*
*/
    
    function validate_task($args, $url)
    {
        if (!class_exists('WP_Http')) {
            include_once(ABSPATH . WPINC . '/class-http.php');
        }
        $params         = array();
        $params['body'] = $args;
        $result         = wp_remote_post($url, $params);
        if (is_array($result) && $result['body'] == 'iwp_delete_task') {
            //$tasks = $this->get_backup_settings();
            $tasks = $this->tasks;
            unset($tasks[$args['task_name']]);
            $this->update_tasks($tasks);
            $this->cleanup();
            exit;
        } elseif(is_array($result) && $result['body'] == 'iwp_pause_task'){
        	return 'paused';
        } 
        
        return 'ok';
    }
    
    function update_status($task_name, $status, $completed = false)
    {
        /* Statuses:
        0 - Backup started
        1 - DB dump
        2 - DB ZIP
        3 - Files ZIP
        4 - Amazon S3
        5 - Dropbox
        6 - FTP
        7 - Email
        100 - Finished
        */
        if ($task_name != 'Backup Now') {
            $tasks = $this->tasks;
            $index = count($tasks[$task_name]['task_results']) - 1;
            if (!is_array($tasks[$task_name]['task_results'][$index]['status'])) {
                $tasks[$task_name]['task_results'][$index]['status'] = array();
            }
            if (!$completed) {
                $tasks[$task_name]['task_results'][$index]['status'][] = (int) $status * (-1);
            } else {
                $status_index                                                       = count($tasks[$task_name]['task_results'][$index]['status']) - 1;
                $tasks[$task_name]['task_results'][$index]['status'][$status_index] = abs($tasks[$task_name]['task_results'][$index]['status'][$status_index]);
            }
            
            $this->update_tasks($tasks);
            //update_option('iwp_client_backup_tasks',$tasks);
        }
    }
    
    function update_tasks($tasks)
    {
        $this->tasks = $tasks;
        update_option('iwp_client_backup_tasks', $tasks);
    }
    
    function wpdb_reconnect(){
    	global $wpdb;
		$old_wpdb = $wpdb;
    	//Reconnect to avoid timeout problem after ZIP files
      	if(class_exists('wpdb') && function_exists('wp_set_wpdb_vars')){
      		@mysql_close($wpdb->dbh);
        	$wpdb = new wpdb( DB_USER, DB_PASSWORD, DB_NAME, DB_HOST );
        	wp_set_wpdb_vars(); 
			$wpdb->options = $old_wpdb->options;//fix for multi site full backup
      	}
    }
    
  function replace_htaccess($url)
	{
    $file = @file_get_contents(ABSPATH.'.htaccess');
    if ($file && strlen($file)) {
        $args    = parse_url($url);        
        $string  = rtrim($args['path'], "/");
        $regex   = "/BEGIN WordPress(.*?)RewriteBase(.*?)\n(.*?)RewriteRule \.(.*?)index\.php(.*?)END WordPress/sm";
        $replace = "BEGIN WordPress$1RewriteBase " . $string . "/ \n$3RewriteRule . " . $string . "/index.php$5END WordPress";
        $file    = preg_replace($regex, $replace, $file);
        @file_put_contents(ABSPATH.'.htaccess', $file);
    }
	}
    
	function check_cron_remove(){
		if(empty($this->tasks) || (count($this->tasks) == 1 && isset($this->tasks['Backup Now'])) ){
			wp_clear_scheduled_hook('iwp_client_backup_tasks');
			exit;
		}
	}

    
	public static function readd_tasks( $params = array() ){
		global $iwp_mmb_core;
		
		if( empty($params) || !isset($params['backups']) )
			return $params;
		
		$before = array();
		$tasks = $params['backups'];
		if( !empty($tasks) ){
			$iwp_mmb_backup = new IWP_MMB_Backup();
			
			if( function_exists( 'wp_next_scheduled' ) ){
				if ( !wp_next_scheduled('iwp_client_backup_tasks') ) {
					wp_schedule_event( time(), 'tenminutes', 'iwp_client_backup_tasks' );
				}
			}
			
			foreach( $tasks as $task ){
				$before[$task['task_name']] = array();
				
				if(isset($task['secure'])){
					if($decrypted = $iwp_mmb_core->_secure_data($task['secure'])){
						$decrypted = maybe_unserialize($decrypted);
						if(is_array($decrypted)){
							foreach($decrypted as $key => $val){
								if(!is_numeric($key))
									$task[$key] = $val;							
							}
							unset($task['secure']);
						} else 
							$task['secure'] = $decrypted;
					}
					
				}
				if (isset($task['account_info']) && is_array($task['account_info'])) { //only if sends from master first time(secure data)
					$task['args']['account_info'] = $task['account_info'];
				}
				
				$before[$task['task_name']]['task_args'] = $task['args'];
				$before[$task['task_name']]['task_args']['next'] = $iwp_mmb_backup->schedule_next($task['args']['type'], $task['args']['schedule']);
			}
		}
		update_option('iwp_client_backup_tasks', $before);
		
		unset($params['backups']);
		return $params;
	}
}

if( function_exists('add_filter') ){
	add_filter( 'iwp_website_add', 'IWP_MMB_Backup::readd_tasks' );
}
?>