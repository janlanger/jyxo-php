<?php declare(strict_types = 1);

/**
 * Jyxo PHP Library
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file license.txt.
 * It is also available through the world-wide-web at this URL:
 * https://github.com/jyxo/php/blob/master/license.txt
 */

namespace Jyxo\Mail\Email\Attachment;

/**
 * \Jyxo\Mail\Email\Attachment\InlineFileAttachment class test.
 *
 * @see \Jyxo\Mail\Email\Attachment\InlineFile
 * @copyright Copyright (c) 2005-2011 Jyxo, s.r.o.
 * @license https://github.com/jyxo/php/blob/master/license.txt
 * @author Jaroslav Hanslík
 */
class InlineFileAttachmentTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * Runs the test.
	 */
	public function test()
	{
		$path = DIR_FILES . '/mail/logo.gif';
		$name = 'logo.gif';
		$cid = 'logo.gif';
		$mimeType = 'image/gif';

		$attachment = new InlineFileAttachment($path, $name, $cid, $mimeType);
		$this->assertEquals(file_get_contents($path), $attachment->getContent());
		$this->assertEquals($name, $attachment->getName());
		$this->assertEquals($mimeType, $attachment->getMimeType());
		$this->assertEquals(\Jyxo\Mail\Email\Attachment::DISPOSITION_INLINE, $attachment->getDisposition());
		$this->assertTrue($attachment->isInline());
		$this->assertEquals($cid, $attachment->getCid());
		$this->assertEquals('', $attachment->getEncoding());
	}
}
