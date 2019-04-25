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

class File
{
    
    private $file = [];

	public function data($field, $absolute_dir, $relative_dir, $type):string
	{

		$this->file['type'] = $type;
		$this->file['field'] = $field;
		$this->file['absolute_dir'] = $absolute_dir;
		$this->file['relative_dir'] = $relative_dir;
		return $this->path();

	}

	public function path()
	{

		try
		{

			switch($this->file['type'])
			{
				case 'pdf':
					$allowed_mimes = array('application/pdf');
					break;
				case 'image':
					$allowed_mimes = array('image/png', 'image/jpeg', 'image/gif', 'image/pjpeg');
					break;
				case 'doc':
					$allowed_mimes = array('application/msword', 'application/docx', 'application/doc', 'application/application/vnd.openxmlformats-officedocument.wordprocessingml.document');
					break;
				default:
					$allowed_mimes = [];
					break;
			}

			
			$file_name = $this->location($this->file['field'], $this->file['absolute_dir'], $allowed_mimes);

			if(!$file_name)
			{
			   	return 'File not available';
			}else
			{
				return $this->file['relative_dir'] . $file_name;
			}


		}
		catch(Exception $e)
		{
			echo $e->getMessage();
		}

	}

	public function location($file_path, $destination_dir, array $allowed_mimes = array()):mixed
	{

		try{

			if(!is_file($file_path) || !is_dir($destination_dir))
			{
		        return false;
		    }

			if(!($mime = $this->mimeType($file_path)))
			{
		        return false;
		    }

			if(!in_array($mime, $allowed_mimes))
			{
		        return false;
		    }

		    $ext = null;
		    $ext_mapping = $this->extensionToMimeTypeMapping();

			foreach($ext_mapping as $extension => $mime_type)
			{
				if($mime_type == $mime)
				{
		            $ext = $extension;
		            break;
		        }
		    }

			if(empty($ext))
			{
		        $ext = pathinfo($file_path, PATHINFO_EXTENSION);
		    }

			if(empty($ext))
			{
		        return false;
		    }

		    $file_name = md5(uniqid(chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0), true)) . '.' . $ext;
		    $new_file_path = $destination_dir.'/'.$file_name;

			if(!rename($file_path, $new_file_path))
			{
		        return false;
		    }

		    return $file_name;

		}
		catch(Exception $e)
		{
			echo $e->getMessage();
		}

	}


	public function extensionToMimeTypeMapping():array
	{
		return [
	        'ai'=>'application/postscript',
	        'aif'=>'audio/x-aiff',
	        'aifc'=>'audio/x-aiff',
	        'aiff'=>'audio/x-aiff',
	        'anx'=>'application/annodex',
	        'asc'=>'text/plain',
	        'au'=>'audio/basic',
	        'avi'=>'video/x-msvideo',
	        'axa'=>'audio/annodex',
	        'axv'=>'video/annodex',
	        'bcpio'=>'application/x-bcpio',
	        'bin'=>'application/octet-stream',
	        'bmp'=>'image/bmp',
	        'c'=>'text/plain',
	        'cc'=>'text/plain',
	        'ccad'=>'application/clariscad',
	        'cdf'=>'application/x-netcdf',
	        'class'=>'application/octet-stream',
	        'cpio'=>'application/x-cpio',
	        'cpt'=>'application/mac-compactpro',
	        'csh'=>'application/x-csh',
	        'css'=>'text/css',
	        'csv'=>'text/csv',
	        'dcr'=>'application/x-director',
	        'dir'=>'application/x-director',
	        'dms'=>'application/octet-stream',
			'doc'=>'application/msword',
			'docx' => 'application/docx',
			'doc' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
	        'drw'=>'application/drafting',
	        'dvi'=>'application/x-dvi',
	        'dwg'=>'application/acad',
	        'dxf'=>'application/dxf',
	        'dxr'=>'application/x-director',
	        'eps'=>'application/postscript',
	        'etx'=>'text/x-setext',
	        'exe'=>'application/octet-stream',
	        'ez'=>'application/andrew-inset',
	        'f'=>'text/plain',
	        'f90'=>'text/plain',
	        'flac'=>'audio/flac',
	        'fli'=>'video/x-fli',
	        'flv'=>'video/x-flv',
	        'gif'=>'image/gif',
	        'gtar'=>'application/x-gtar',
	        'gz'=>'application/x-gzip',
	        'h'=>'text/plain',
	        'hdf'=>'application/x-hdf',
	        'hh'=>'text/plain',
	        'hqx'=>'application/mac-binhex40',
	        'htm'=>'text/html',
	        'html'=>'text/html',
	        'ice'=>'x-conference/x-cooltalk',
	        'ief'=>'image/ief',
	        'iges'=>'model/iges',
	        'igs'=>'model/iges',
	        'ips'=>'application/x-ipscript',
	        'ipx'=>'application/x-ipix',
	        'jpe'=>'image/jpeg',
	        'jpeg'=>'image/jpeg',
	        'jpg'=>'image/jpeg',
	        'js'=>'application/x-javascript',
	        'kar'=>'audio/midi',
	        'latex'=>'application/x-latex',
	        'lha'=>'application/octet-stream',
	        'lsp'=>'application/x-lisp',
	        'lzh'=>'application/octet-stream',
	        'm'=>'text/plain',
	        'man'=>'application/x-troff-man',
	        'me'=>'application/x-troff-me',
	        'mesh'=>'model/mesh',
	        'mid'=>'audio/midi',
	        'midi'=>'audio/midi',
	        'mif'=>'application/vnd.mif',
	        'mime'=>'www/mime',
	        'mov'=>'video/quicktime',
	        'movie'=>'video/x-sgi-movie',
	        'mp2'=>'audio/mpeg',
	        'mp3'=>'audio/mpeg',
	        'mpe'=>'video/mpeg',
	        'mpeg'=>'video/mpeg',
	        'mpg'=>'video/mpeg',
	        'mpga'=>'audio/mpeg',
			'ms'=>'application/x-troff-ms',
			'msword' => 'application/msword',
	        'msh'=>'model/mesh',
			'nc'=>'application/x-netcdf',
	        'oga'=>'audio/ogg',
	        'ogg'=>'audio/ogg',
	        'ogv'=>'video/ogg',
	        'ogx'=>'application/ogg',
	        'oda'=>'application/oda',
	        'pbm'=>'image/x-portable-bitmap',
	        'pdb'=>'chemical/x-pdb',
	        'pdf'=>'application/pdf',
	        'pgm'=>'image/x-portable-graymap',
	        'pgn'=>'application/x-chess-pgn',
	        'png'=>'image/png',
	        'pnm'=>'image/x-portable-anymap',
	        'pot'=>'application/mspowerpoint',
	        'ppm'=>'image/x-portable-pixmap',
	        'pps'=>'application/mspowerpoint',
	        'ppt'=>'application/mspowerpoint',
	        'ppz'=>'application/mspowerpoint',
	        'pre'=>'application/x-freelance',
	        'prt'=>'application/pro_eng',
	        'ps'=>'application/postscript',
	        'qt'=>'video/quicktime',
	        'ra'=>'audio/x-realaudio',
	        'ram'=>'audio/x-pn-realaudio',
	        'ras'=>'image/cmu-raster',
	        'rgb'=>'image/x-rgb',
	        'rm'=>'audio/x-pn-realaudio',
	        'roff'=>'application/x-troff',
	        'rpm'=>'audio/x-pn-realaudio-plugin',
	        'rtf'=>'text/rtf',
	        'rtx'=>'text/richtext',
	        'scm'=>'application/x-lotusscreencam',
	        'set'=>'application/set',
	        'sgm'=>'text/sgml',
	        'sgml'=>'text/sgml',
	        'sh'=>'application/x-sh',
	        'shar'=>'application/x-shar',
	        'silo'=>'model/mesh',
	        'sit'=>'application/x-stuffit',
	        'skd'=>'application/x-koan',
	        'skm'=>'application/x-koan',
	        'skp'=>'application/x-koan',
	        'skt'=>'application/x-koan',
	        'smi'=>'application/smil',
	        'smil'=>'application/smil',
	        'snd'=>'audio/basic',
	        'sol'=>'application/solids',
	        'spl'=>'application/x-futuresplash',
	        'spx'=>'audio/ogg',
	        'src'=>'application/x-wais-source',
	        'step'=>'application/STEP',
	        'stl'=>'application/SLA',
	        'stp'=>'application/STEP',
	        'sv4cpio'=>'application/x-sv4cpio',
	        'sv4crc'=>'application/x-sv4crc',
	        'swf'=>'application/x-shockwave-flash',
	        't'=>'application/x-troff',
	        'tar'=>'application/x-tar',
	        'tcl'=>'application/x-tcl',
	        'tex'=>'application/x-tex',
	        'texi'=>'application/x-texinfo',
	        'texinfo'=>'application/x-texinfo',
	        'tif'=>'image/tiff',
	        'tiff'=>'image/tiff',
	        'tr'=>'application/x-troff',
	        'tsi'=>'audio/TSP-audio',
	        'tsp'=>'application/dsptype',
	        'tsv'=>'text/tab-separated-values',
	        'txt'=>'text/plain',
	        'unv'=>'application/i-deas',
	        'ustar'=>'application/x-ustar',
	        'vcd'=>'application/x-cdlink',
	        'vda'=>'application/vda',
	        'viv'=>'video/vnd.vivo',
	        'vivo'=>'video/vnd.vivo',
	        'vrml'=>'model/vrml',
	        'wav'=>'audio/x-wav',
	        'wrl'=>'model/vrml',
	        'xbm'=>'image/x-xbitmap',
	        'xlc'=>'application/vnd.ms-excel',
	        'xll'=>'application/vnd.ms-excel',
	        'xlm'=>'application/vnd.ms-excel',
	        'xls'=>'application/vnd.ms-excel',
	        'xlw'=>'application/vnd.ms-excel',
	        'xml'=>'application/xml',
	        'xpm'=>'image/x-xpixmap',
	        'xspf'=>'application/xspf+xml',
	        'xwd'=>'image/x-xwindowdump',
	        'xyz'=>'chemical/x-pdb',
	        'zip'=>'application/zip'
        ];
	}

	public function mimeType($file_path):mixed
	{
		try
		{
			if(!is_file($file_path))
			{
		        return false;
		    }

		    $finfo = finfo_open(FILEINFO_MIME_TYPE);
		    $mime = finfo_file($finfo, $file_path);
		    finfo_close($finfo);

		    return $mime;

		}
		catch(Exception $e)
		{
			echo $e->getMessage();
		}

	}

}
