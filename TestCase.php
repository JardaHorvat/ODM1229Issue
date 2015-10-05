<?php

namespace App;

use Doctrine\ODM\MongoDB\DocumentManager;
use App\Documents\Files\GenericFile;
use App\Documents\Files\ImageFile;
use App\Documents\Folder;

class TestCase
{
	/** @var DocumentManager */
	private $dm;

	/**
	 * Test constructor.
	 * @param DocumentManager $dm
	 */
	function __construct( DocumentManager $dm )
	{
		$this->dm = $dm;
	}

	/**
	 * @return Folder[]
	 */
	function createTestDataA()
	{
		$this->dm->getSchemaManager()->dropDocumentCollection('App\Documents\Folder');

		$a = new Folder('a');
		$a->addFile( new GenericFile('readme.txt'));
		$a->addFile( new ImageFile('cat.jpg', 460, 320 ));
		$a->addFile( new ImageFile('dog.jpg', 1000, 800 ));
		$a->addFile( new GenericFile('notice.pdf'));
		$a->addFile( new GenericFile('logo.zip'));
		$a->addFile( new GenericFile('virus.exe'));

		$b = new Folder('b');

		$this->dm->persist( $a );
		$this->dm->persist( $b );
		$this->dm->flush();
		$this->dm->clear();

		return array( $a, $b );
	}

	/**
	 * @return Folder[]
	 */
	function createTestDataB()
	{
		$this->dm->getSchemaManager()->dropDocumentCollection('App\Documents\Folder');

		$a = new Folder('a');
		$a->addFile( new GenericFile('readme.txt'));
		$a->addFile( new ImageFile('cat.jpg', 460, 320 ));
		$a->addFile( new ImageFile('dog.jpg', 1000, 800 ));
		$a->addFile( new GenericFile('notice.pdf'));
		$a->addFile( new GenericFile('logo.zip'));
		$a->addFile( new GenericFile('virus.exe'));

		$b = new Folder('b');
		$b->addFile( new GenericFile('script.php'));

		$this->dm->persist( $a );
		$this->dm->persist( $b );
		$this->dm->flush();
		$this->dm->clear();

		return array( $a, $b );
	}

	/**
	 * @return Folder[]
	 */
	function getTestData()
	{
		return array( $this->getFolder('a'), $this->getFolder('b') );
	}

	/**
	 * @param string $id
	 * @return Folder
	 */
	private function getFolder( $id )
	{
		$folder = $this->dm->getRepository('App\Documents\Folder')->find( $id );

		if( !$folder ) {
			throw new \RuntimeException('Missing test data!');
		}

		return $folder;
	}

	/**
	 * @return Folder[]
	 */
	function methodA()
	{
		$a = $this->getFolder('a');
		$b = $this->getFolder('b');

		foreach( $a->getFiles() as $file ) {
			if( $file->getOrder() === 1 ) {
				$a->removeFile( $file );
				$b->addFile( $file );

				$this->dm->flush();
				$this->dm->clear();

				return array( $a, $b );
			}
		}

		throw new \RuntimeException('Test folder A has run out of files!');
	}

	/**
	 * @return Folder[]
	 */
	function methodB()
	{
		$a = $this->getFolder('a');
		$b = $this->getFolder('b');

		foreach( $a->getFiles() as $file ) {
			if( $file->getOrder() === 1 ) {
				$a->removeFile( $file );

				$this->dm->detach( $file );

				$b->addFile( $file );

				$this->dm->flush();
				$this->dm->clear();

				return array( $a, $b );
			}
		}

		throw new \RuntimeException('Test folder A has run out of files!');
	}
}