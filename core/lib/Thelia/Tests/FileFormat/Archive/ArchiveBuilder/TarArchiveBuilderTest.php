<?php
/*************************************************************************************/
/*      This file is part of the Thelia package.                                     */
/*                                                                                   */
/*      Copyright (c) OpenStudio                                                     */
/*      email : dev@thelia.net                                                       */
/*      web : http://www.thelia.net                                                  */
/*                                                                                   */
/*      For the full copyright and license information, please view the LICENSE.txt  */
/*      file that was distributed with this source code.                             */
/*************************************************************************************/

namespace Thelia\Tests\FileFormat\Archive\ArchiveBuilder;
use Symfony\Component\DependencyInjection\Container;
use Thelia\Core\FileFormat\Archive\ArchiveBuilder\TarArchiveBuilder;
use Thelia\Core\Translation\Translator;
use Thelia\Log\Tlog;

/**
 * Class TarArchiveBuilderTest
 * @package Thelia\Tests\FileFormat\Archive\ArchiveBuilder
 * @author Benjamin Perche <bperche@openstudio.fr>
 */
class TarArchiveBuilderTest extends \PHPUnit_Framework_TestCase
{
    /** @var  TarArchiveBuilder */
    protected $tar;

    public function setUp()
    {
        new Translator(new Container());

        Tlog::getNewInstance();

        $this->tar = new TarArchiveBuilder();
        $this->tar->setEnvironment("dev");
    }

    public function testAddFileAndDirectory()
    {
        /**
         * File
         */
        $tar = $this->tar->addFile(
            __DIR__ . DS . "TestResources/test_file"
        );

        $this->assertTrue($tar->hasFile("test_file"));

        $this->assertFalse($tar->hasDirectory("test_file"));

        $tar = $this->tar->addFile(
            __DIR__ . DS . "TestResources/test_file",
            null,
            "TEST.txt"
        );

        $this->assertTrue($tar->hasFile("TEST.txt"));

        $this->assertFalse($tar->hasDirectory("TEST.txt"));

        /**
         * Directory
         */
        $this->tar->addDirectory("foo");

        $this->assertTrue($tar->hasDirectory("foo"));

        $this->assertFalse($tar->hasFile("foo"));

        /**s
         * File in a directory
         */
        $this->tar->addFile(
            __DIR__ . DS . "TestResources/test_file",
            "bar",
            "baz"
        );

        $this->assertTrue($this->tar->hasFile("bar/baz"));

        $this->assertTrue($this->tar->hasDirectory("bar"));

    }

    public function testAddValidFileFromString()
    {
        $this->tar->addFileFromString(
            "foo", "bar"
        );

        $this->assertTrue(
            $this->tar->hasFile("bar")
        );

        $this->assertEquals(
            "foo",
            $this->tar->getFileContent("bar")
        );

        $this->tar->addFileFromString(
            "foo", "bar", "baz"
        );

        $this->assertTrue(
            $this->tar->hasFile("baz/bar")
        );

        $this->assertEquals(
            "foo",
            $this->tar->getFileContent("baz/bar")
        );
    }

    /**
     * @expectedException \ErrorException
     */
    public function testAddNotValidFileFromString()
    {
        $this->tar->addFileFromString(
            "foo", $this
        );
    }

    /**
     * @expectedException \ErrorException
     */
    public function testAddNotValidFileValueFromString()
    {
        $this->tar->addFileFromString(
            $this, "foo"
        );
    }


    public function testDeleteFile()
    {
        $this->tar->addFileFromString(
            "foo", "bar"
        );

        $this->assertTrue(
            $this->tar->hasFile("bar")
        );

        $this->tar->deleteFile("bar");

        $this->assertFalse(
            $this->tar->hasFile("bar")
        );
    }
} 