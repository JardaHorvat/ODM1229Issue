<?php

namespace App\Documents\Files;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\EmbeddedDocument
 */
class ImageFile extends GenericFile
{
	/**
	 * @var int
	 * @ODM\Int
	 */
	protected $width;

	/**
	 * @var int
	 * @ODM\Int
	 */
	protected $height;

	/**
	 * ImageFile constructor.
	 * @param string $file
	 * @param int $width
	 * @param int $height
	 */
	function __construct( $file, $width, $height )
	{
		parent::__construct( $file );

		$this->width = $width;
		$this->height = $height;
	}

	/**
	 * @return int
	 */
	function getWidth()
	{
		return $this->width;
	}

	/**
	 * @return int
	 */
	function getHeight()
	{
		return $this->height;
	}
}