<?php

namespace App\Documents\Files;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\EmbeddedDocument
 */
class GenericFile
{
	/**
	 * @var string
	 * @ODM\Id( strategy = "NONE")
	 */
	protected $id;

	/**
	 * @var string
	 * @ODM\String
	 */
	protected $file;

	/**
	 * @var int
	 * @ODM\Int
	 */
	protected $order;

	/**
	 * GenericFile constructor.
	 * @param $file
	 */
	function __construct( $file )
	{
		$this->id = new \MongoId;
		$this->file = $file;
	}

	/**
	 * @return string
	 */
	function getId()
	{
		return $this->id;
	}

	/**
	 * @return string
	 */
	function getFile()
	{
		return $this->file;
	}

	/**
	 * @param int $order
	 */
	function setOrder( $order )
	{
		$this->order = $order;
	}

	/**
	 * @return int
	 */
	function getOrder()
	{
		return $this->order;
	}
}