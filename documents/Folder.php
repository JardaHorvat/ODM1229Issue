<?php

namespace App\Documents;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Doctrine\Common\Collections\ArrayCollection;
use App\Documents\Files\GenericFile;

/**
 * @ODM\Document
 */
class Folder
{
	/**
	 * @var string
	 * @ODM\Id( strategy = "NONE")
	 */
	protected $id;

	/**
	 * @var GenericFile[]
	 * @ODM\EmbedMany( discriminatorField = "_class")
	 */
	protected $files;

	/**
	 * Folder constructor.
	 * @param string $id
	 */
	function __construct( $id )
	{
		$this->id = $id;
		$this->files = new ArrayCollection;
	}

	/**
	 * @param GenericFile $file
	 */
	function addFile( GenericFile $file )
	{
		$file->setOrder( count( $this->files ));

		$this->files->add( $file );
	}

	/**
	 * @param GenericFile $file
	 */
	function removeFile( GenericFile $file )
	{
		$this->files->removeElement( $file );

		$this->adjustFileOrder( $file->getOrder(), -1 );
	}

	/**
	 * @return GenericFile[]
	 */
	function getFiles()
	{
		return $this->files->toArray();
	}

	/**
	 * @param int $starting
	 * @param int $change
	 */
	private function adjustFileOrder( $starting, $change )
	{
		foreach( $this->getFiles() as $file ) {
			if( $file->getOrder() >= $starting ) {
				$file->setOrder( $file->getOrder() + $change );
			}
		}
	}
}