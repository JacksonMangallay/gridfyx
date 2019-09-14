<?php declare(strict_types = 1);
/**
 *---------------------------------------------------------------------------------
 * GRIDFYX PHP FRAMEWORK
 *---------------------------------------------------------------------------------
 *
 * A progressive PHP framework for small to medium scale web applications
 *
 * MIT License
 *
 * Copyright (c) 2019 Jackson
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 *
 *
 * @package	Gridfyx PHP Framework
 * @author	Jackson Mangallay
 * @license	MIT License
 * @link	https://github.com/JacksonMangallay/gridfyx
 * @since	Version 1.0.0
 *
 */
namespace System\Library;

defined('BASEPATH') OR exit('Direct access is forbidden');

use Exception;

final class File{
    
    private $file = null;

	/**
	 * 
	 * @param string $field
	 * @param string $absolute_dir
	 * @param string $relative_dir
	 * @param string $type
	 * 
     * @return mixed
     */
	public function upload($field = '', $absolute_dir = '', $relative_dir = '', $type = ''){

		$this->file = array(
			'field' => $field,
			'absolute_dir' => $absolute_dir,
			'relative_dir' => $relative_dir,
			'type' => $type
		);

		return $this->path();

	}

	/**
	 * 
     * @return mixed
     */
	private function path(){

		try{

			switch($this->file['type']){
				case 'image':
					$allowed_mimes = $this->image_mimes();
					break;

				case 'doc':
					$allowed_mimes = $this->doc_mimes();
					break;

				case 'file':
					$allowed_mimes = $this->file_mimes();
					break;

				case 'audio':
					$allowed_mimes = $this->audio_mimes();
					break;

				case 'video':
					$allowed_mimes = $this->video_mimes();
					break;
			}
			
			$file_name = $this->location($this->file['field'], $this->file['absolute_dir'], $allowed_mimes);

			if(!$file_name){
			   	return false;
			}else{
				return $this->file['relative_dir'] . $file_name;
			}


		}catch(Exception $e){
			throw new Exception($e->getMessage());
		}

	}

	/**
	 * 
	 * @param string $file_path
	 * @param string $destination_dir
	 * @param array $allowed_mimes
	 * 
     * @return mixed
     */
	private function location($file_path = '', $destination_dir = '', $allowed_mimes = array()){

		try{

			if(!is_file($file_path) || !is_dir($destination_dir)){
		        return false;
		    }

			if(!($mime = $this->mime_type($file_path))){
		        return false;
		    }

			if(!in_array($mime, $allowed_mimes)){
		        return false;
		    }

		    $ext = null;
		    $ext_mapping = $this->mime_extension_mapping();

			foreach($ext_mapping as $extension => $mime_type){
				if($mime_type == $mime){
		            $ext = $extension;
		            break;
		        }
		    }

			if(empty($ext)){
		        $ext = pathinfo($file_path, PATHINFO_EXTENSION);
		    }

			if(empty($ext)){
		        return false;
		    }

		    $file_name = md5(uniqid(chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0), true)) . '.' . $ext;
		    $new_file_path = $destination_dir.'/'.$file_name;

			if(!rename($file_path, $new_file_path)){
		        return false;
		    }

		    return $file_name;

		}catch(Exception $e){
			throw new Exception($e->getMessage());
		}

	}

	/**
	 * 
     * @return array
     */
	private function image_mimes(){
		return array(
			'image/bmp',
			'image/gif',
			'image/jpeg',
			'image/jpg',
			'image/png',
		);
	}

	/**
	 * 
     * @return array
     */
	private function doc_mimes(){
		return array(
			'text/csv',
			'application/msword',
			'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
			'application/vnd.ms-access',
			'application/pdf',
			'application/vnd.ms-powerpoint',
			'text/plain',
			'application/vnd.ms-excel',
			'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
		);
	}
	
	/**
	 * 
     * @return array
     */
	private function file_mimes(){
		return array(
			'text/css',
			'application/x-gzip',
			'text/html',
			'application/x-javascript',
			'application/x-httpd-php',
			'application/zip'
		);
	}

	/**
	 * 
     * @return array
     */
	private function audio_mimes(){
		return array(
			'audio/midi',
	        'audio/mpeg',
	        'audio/ogg',
		);
	}

	/**
	 * 
     * @return array
     */
	private function video_mimes(){
		return array(
			'video/x-msvideo',
	        'video/x-fli',
			'video/x-flv',
	        'video/quicktime',
			'video/x-sgi-movie',
	        'video/mpeg',
			'video/ogg'
		);
	}

	/**
	 * 
     * @return array
     */
	private function allowedMimes(){

		$mimes = array_merge($this->image_mimes(), $this->doc_mimes());
		$mimes = array_merge($mimes, $this->file_mimes());
		$mimes = array_merge($mimes, $this->audio_mimes());
		$mimes = array_merge($mimes, $this->video_mimes());
		return $mimes;
	}

	/**
	 * 
     * @return array
     */
	private function mime_extension_mapping(){

		$image_mimes = array(
			'bmp' => 'image/bmp',
			'gif' => 'image/gif',
			'jpe' => 'image/jpeg',
			'jpeg' => 'image/jpeg',
			'jpg' => 'image/jpg',
			'png'=>'image/png',
		);

		$doc_mimes = array(
			'csv' => 'text/csv',
			'doc' => 'application/msword',
			'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
			'mdb' => 'application/vnd.ms-access',
			'pdf'=>'application/pdf',
			'ppt' => 'application/vnd.ms-powerpoint',
			'ppa' => 'application/vnd.ms-powerpoint',
			'pps' => 'application/vnd.ms-powerpoint',
			'pot' => 'application/vnd.ms-powerpoint',
			'txt' => 'text/plain',
			'xls' => 'application/vnd.ms-excel',
			'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
		);

		$file_mimes = array(
			'css' => 'text/css',
			'gz' => 'application/x-gzip',
			'htm' => 'text/html',
			'html' => 'text/html',
			'js'=>'application/x-javascript',
			'php' => 'application/x-httpd-php',
			'zip'=>'application/zip'
		);

		$audio_mimes = array(
	        'mid'=>'audio/midi',
			'midi'=>'audio/midi',
	        'mp2'=>'audio/mpeg',
			'mp3'=>'audio/mpeg',
			'mpga'=>'audio/mpeg',
	        'oga'=>'audio/ogg',
	        'ogg'=>'audio/ogg',
		);

		$video_mimes = array(
			'avi'=>'video/x-msvideo',
	        'fli'=>'video/x-fli',
			'flv'=>'video/x-flv',
	        'mov'=>'video/quicktime',
			'movie'=>'video/x-sgi-movie',
	        'mpe'=>'video/mpeg',
	        'mpeg'=>'video/mpeg',
			'mpg'=>'video/mpeg',
			'ogv'=>'video/ogg'
		);

		$map = array_merge($image_mimes, $doc_mimes);
		$map = array_merge($map, $file_mimes);
		$map = array_merge($map, $audio_mimes);
		$map = array_merge($map, $video_mimes);

		return $map;

	}

	/**
	 * 
	 * @param string $file_path
	 * 
     * @return mixed
     */
	private function mime_type($file_path = ''){

		try{

			if(!is_file($file_path)){
		        return false;
		    }

		    $finfo = finfo_open(FILEINFO_MIME_TYPE);
		    $mime = finfo_file($finfo, $file_path);
		    finfo_close($finfo);

		    return $mime;

		}catch(Exception $e){
			throw new Exception($e->getMessage());
		}

	}

}
