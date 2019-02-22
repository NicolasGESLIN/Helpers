<?php
/**
 * This file is part of Berlioz framework.
 *
 * @license   https://opensource.org/licenses/MIT MIT License
 * @copyright 2019 Ronan GIRON
 * @author    Ronan GIRON <https://github.com/ElGigi>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code, to the root.
 */

namespace Berlioz\Helpers\Tests;

use Berlioz\Helpers\StringHelper;
use PHPUnit\Framework\TestCase;

class StringHelperTest extends TestCase
{
    public function testRandom()
    {
        // Length
        $this->assertEquals(12, mb_strlen(StringHelper::random(12)));
        $this->assertEquals(256, mb_strlen(StringHelper::random(256)));
        $this->assertEquals(1024, mb_strlen(StringHelper::random(1024)));

        // Only characters
        $this->assertRegExp('/^[a-z]+$/', StringHelper::random(32, StringHelper::RANDOM_LOWER_CASE));

        // With special characters & Not required
        $str = StringHelper::random(32, StringHelper::RANDOM_SPECIAL_CHARACTERS);
        $this->assertRegExp('/^[^0-9]+$/', $str);

        // With numbers & special characters & Required
        $str = StringHelper::random(32,
                                    StringHelper::RANDOM_NUMBER |
                                    StringHelper::RANDOM_SPECIAL_CHARACTERS |
                                    StringHelper::RANDOM_NEED_ALL);
        $this->assertRegExp('/[0-9]+/', $str);
        $this->assertRegExp('/[a-z]+/', $str);
        $this->assertRegExp('/[A-Z]+/', $str);
        $this->assertRegExp('/[^0-9a-z]+/i', $str);
    }

    public function testNl2p()
    {
        $this->assertEquals("<p>Test</p>\n<p>Test</p>", StringHelper::nl2p("Test\n\nTest"));
        $this->assertEquals("<p>Test<br />\nTest</p>", StringHelper::nl2p("Test\nTest"));
        $this->assertEquals("<p>Test</p>\n<p>Test<br />\nTest</p>\n<p>Test</p>", StringHelper::nl2p("Test\n\nTest\nTest\n\nTest"));
    }

    public function testRemoveAccents()
    {
        $this->assertEquals('This is a wrong sentence!', StringHelper::removeAccents('Thîs îs à wrong séntènce!'));
        $this->assertEquals('I a lublu PHP!', StringHelper::removeAccents('И я люблю PHP!'));
    }

    public function testStrToUri()
    {
        $this->assertEquals('this-is-a-wrong-sentence', StringHelper::strToUri('Thîs îs à wrong séntènce!'));
        $this->assertEquals('i-a-lublu-php', StringHelper::strToUri('И я люблю PHP!'));
    }

    public function testMinifyHtml()
    {
        $this->assertEquals("<p> Test </p> <p> Test test </p>",
                            StringHelper::minifyHtml("<p>\nTest\n</p>\n<p>\nTest\n  test\n</p>"));
        $this->assertEquals("<p> Test </p> <textarea>Test   test\nTest\n\n</textarea> <p> Test test </p>",
                            StringHelper::minifyHtml("<p>\nTest\n</p>\n<textarea>Test   test\nTest\n\n</textarea>\n<p>\nTest\n  test\n</p>"));
    }


    public function testPascalCase()
    {
        $this->assertEquals('MyVariable123foo', StringHelper::pascalCase('my_variable_123foo'));
        $this->assertEquals('FooBar', StringHelper::pascalCase('foo_bar'));
        $this->assertEquals('FooBar', StringHelper::pascalCase('fooBar'));
    }

    public function testCamelCase()
    {
        $this->assertEquals('myVariable123foo', StringHelper::camelCase('my_variable_123foo'));
        $this->assertEquals('fooBar', StringHelper::camelCase('foo_bar'));
        $this->assertEquals('fooBar', StringHelper::camelCase('FooBar'));
    }

    public function testSnakeCase()
    {
        $this->assertEquals('my_variable_123foo', StringHelper::snakeCase('my_variable_123foo'));
        $this->assertEquals('foo_bar', StringHelper::snakeCase('foo_bar'));
        $this->assertEquals('foo_bar', StringHelper::snakeCase('fooBar'));
        $this->assertEquals('foo_bar1234', StringHelper::snakeCase('fooBar1234'));
        $this->assertEquals('foo_bar1234_foo', StringHelper::snakeCase('fooBar1234Foo'));
        $this->assertEquals('foo_bar', StringHelper::snakeCase('FooBar'));
    }

    public function testSpinalCase()
    {
        $this->assertEquals('my-variable-123foo', StringHelper::spinalCase('my_variable_123foo'));
        $this->assertEquals('foo-bar', StringHelper::spinalCase('foo_bar'));
        $this->assertEquals('foo-bar', StringHelper::spinalCase('fooBar'));
        $this->assertEquals('foo-bar1234', StringHelper::spinalCase('fooBar1234'));
        $this->assertEquals('foo-bar1234-foo', StringHelper::spinalCase('fooBar1234Foo'));
        $this->assertEquals('foo-bar', StringHelper::spinalCase('FooBar'));
    }
}
