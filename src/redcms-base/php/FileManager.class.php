<?php

/* RedCMS
 * 
 * Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
 * Code licensed under the BSD License:
 * http://redcms.red-agent.com/license.html
 */

class FileBlock extends Block {

	var $_dbFieldsMap = ['filePath' => 'text1', 'label' => 'text2'];

	function getLabel() {
		$a = explode('/', $this->filePath);
		if ($this->label != '') {
			return $this->label;
		} else {
			return end($a);
		}  //We strip the file from its path for display
	}

	function getLink() {
		return RedCMS::getInstance()->path . $this->filePath;
	}

	function save() {
		global $_FILES;
		$redCMS = RedCMS::getInstance();

		if (!empty($_FILES)) {
			$relPath = $redCMS->config['publicFilePath'] . $this->parentId . '/';
			$fPath = $redCMS->fullpath . $relPath;
			foreach ($_FILES as $fieldName => $file) {
				switch ($file['error']) {
					case 0:  // No error during upload, proceed with file move
						$fName = $relPath . str_replace(['\\', '/', ':', '*', '?', '"', '<', '>', '|'], ['', '', '', '', '', '', '', '', ''], $file['name']);  //Escape the provided file name of any unwanted chars				
						$fParts = pathinfo($fName);

						$i = 1;
						while (file_exists($redCMS->fullpath . $fName)) {   // If file name already exists, we loop until we find an empty spot
							$fName = $relPath . $fParts['filename'] . '(' . $i . ').' . $fParts['extension'];
							++$i;
						}

						if (!file_exists($fPath)) {
							mkdir($fPath, 0777, true); // If the target directory does not exist, we create it
						}
						move_uploaded_file($file['tmp_name'], $redCMS->fullpath . $fName);

						$this->fields[$fieldName] = $fName;
						break;

					case 1:
					case 2:
					case 3:
					case 4:  // No files were provided for upload
				}
			}
		}
		return parent::save();
	}

	function delete() {
		parent::delete();
		// TODO destroy the target file
	}

}

class PrivateFileBlock extends FileBlock {
	
}

class PictureBlock extends FileBlock {
	
}

class BackupManager extends TreeStructure {

	function render() {
		global $_REQUEST;
		$redCMS = RedCMS::getInstance();

		if (isset($_REQUEST['parentId'])) {
			$fileDir = $redCMS->config['privateFilePath'] . $this->id . '/';
			$filePath = $fileDir . 'Backup-' . date('d.M.y-H.i') . '.sql';

			if (!file_exists($redCMS->fullpath . $fileDir))
				mkdir($redCMS->fullpath . $fileDir, 0777, true);
			$redCMS->dbManager->exportTablesToFile($redCMS->fullpath . $filePath);

			$backupBlock = new BackupFileBlock(['parentId' => $this->id, 'text1' => $filePath, 'type' => 'BackupFileBlock']);
			$backupBlock->save();

			$ret = ['result' => 'success', 'msg' => 'Backup successfully created'];
			echo json_encode($ret);
		} elseif (isset($_REQUEST['id'])) {
			$backupBlock = BlockManager::getBlockById($_REQUEST['id']);

			$redCMS->dbManager->importFile($redCMS->fullpath . $backupBlock->filePath);

			$ret = ['result' => 'success', 'msg' => 'Backup successfully loaded'];
			echo json_encode($ret);
		} else {
			parent::render();
		}
	}

}

class BackupFileBlock extends FileBlock {
	
}
