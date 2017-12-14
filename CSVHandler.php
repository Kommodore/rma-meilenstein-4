<?php


class CSVHandler{
	/**
	 * @var string $fileName The name of the file to open.
	 */
	private $fileName;

	/**
	 * @var array $columns The titles of the columns in an array
	 */
	private $columns = [];

	/**
	 * @var array $content The content of the file without the column titles
	 */
	private $content = [];

	/**
	 * @var bool $loaded If set to false, every method modifying the content array will call the loadFile function.
	 */
	private $loaded = false;

	/**
	 * CSVHandler constructor.
	 *
	 * @param string $fileName The name of the file to open. If not set, setFileName() has to be called.
	 *
	 * @version 1.0.0
	 * @since 1.0.0
	 */
	public function __construct(string $fileName = ""){
		if($fileName != ""){
			$this->fileName = $fileName;
		}
	}

	/**
	 * Set the name of the file to be opened.
	 *
	 * @param string $fileName The file name
	 *
	 * @version 1.0.0
	 * @since 1.0.0
	 *
	 * @throws \InvalidArgumentException $e Throws an error if no filename is set or the file could not be opened.
	 */
	public function setFileName(string $fileName){
		$this->fileName = $fileName;
	}

	public function getColumns(): array{
		if(!$this->loaded){
			try{
				$this->loadFile();
			} catch(InvalidArgumentException $e){
				throw $e;
			}
		}

		return $this->columns;
	}

	/**
	 * Return the content of the csv file. If it wasn't loaded beforehand, load the file.
	 * @return array
	 *
	 * @version 1.0.0
	 * @since 1.0.0
	 *
	 *
	 * @throws \InvalidArgumentException $e Throws an error if no filename is set or the file could not be opened.
	 */
	public function getContent(): array{
		if(!$this->loaded){
			try{
				$this->loadFile();
			} catch(InvalidArgumentException $e){
				throw $e;
			}
		}

		return $this->content;
	}

	/**
	 * Add a new entry for the csv file or edit one. To save the changes, saveFile() has to be called.
	 *
	 * @param array $newContent The new content in the fitting array form.
	 * @param bool  $override Set to true if a position should be overwritten. Column name and $key have to be set.
	 * @param int   $columnPosition The position of the column in the array where the key has to match.
	 * @param int   $key The key where to replace the content.
	 *
	 * @version 1.0.0
	 * @since 1.0.0
	 *
	 * @throws \InvalidArgumentException $e Throws an error if no filename is set or the file could not be opened.
	 */
	public function setContent(array $newContent, bool $override = false, int $columnPosition = 0, int $key = 0){
		if(!$this->loaded){
			try{
				$this->loadFile();
			} catch(InvalidArgumentException $e){
				throw $e;
			}
		}

		if($override == false){
			$this->content[] = $newContent;
		} else {
			for($i = 0; $i < count($this->content); $i++){
				if( $this->content[$i][$columnPosition] == $key){
					$this->content[$i] = $newContent;
				}
			}
		}
	}

	/**
	 *
	 * @param int $columnPosition The position of the column in the array where the key has to match.
	 * @param int $key The key where to replace the content.
	 *
	 * @version 1.0.0
	 * @since 1.0.0
	 *
	 * @throws \InvalidArgumentException $e Throws an error if no filename is set or the file could not be opened.
	 */
	public function deleteContent(int $columnPosition, int $key){
		if(!$this->loaded){
			try{
				$this->loadFile();
			} catch(InvalidArgumentException $e){
				throw $e;
			}
		}

		for($i = 0; $i < count($this->content); $i++){
			if($this->content[$i][$columnPosition] == $key){
				array_splice($this->content, $i, 1);
			}
		}
	}

	/**
	 * Save the file.
	 *
	 * @version 1.0.0
	 * @since 1.0.0
	 *
	 * @throws \InvalidArgumentException $e Throws an error if no filename is set or the file could not be opened.
	 */
	public function saveFile(){
		if(!$this->loaded){
			try{
				$this->loadFile();
			} catch(InvalidArgumentException $e){
				throw $e;
			}
		}

		$file = fopen($this->fileName,"w+");
		fputcsv($file, $this->columns);
		foreach($this->content as $entry){
			fputcsv($file, $entry);
		}
		fclose($file);
	}

	/**
	 * Load a file and save it's content in private member variables.
	 *
	 * @version 1.0.0
	 * @since 1.0.0
	 *
	 * @throws \InvalidArgumentException $e Throws an error if no filename is set or the file could not be opened.
	 */
	private function loadFile(){
		if(!$this->fileName || $this->fileName == ""){
			throw new InvalidArgumentException("Filename not set. Please call setFileName() first");
		}

		$row = 0;
		if(($handle = fopen($this->fileName, "r")) !== FALSE) {
			while(($data = fgetcsv($handle, 1000, ","))  !== false){
				if($row ++ == 0 ) {
					$this->columns = $data;
				} else {
					$this->content[] = $data;
				}
			}
			fclose($handle);
			$this->loaded = true;
		} else {
			throw new InvalidArgumentException("File could not be opened");
		}
	}
}
