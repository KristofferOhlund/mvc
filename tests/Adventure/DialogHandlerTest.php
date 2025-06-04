<?php

namespace App\Adventure;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

class TestDialogHandler extends TestCase
{
    /**
     * Create instance of Human
     */
    public function testDialogInstance()
    {
        $dialog = new DialogHandler();
        $this->assertInstanceOf(DialogHandler::class, $dialog);
    }

    /**
     * Test get dialog by status
     */
    public function testGetDialogByStatus()
    {
        $dialog = new DialogHandler();
        $dialog->setCurrentItem("Shovel");
        $dialog->setCurrentRoom("graveyard");
        $msg = "A rusty shovel, maybe i can dig up some secrets..";
        $this->assertSame($msg, $dialog->getDialogByStatus());
    }

    /**
     * Test get dialog by status
     */
    public function testGetCurrentItem()
    {
        $dialog = new DialogHandler();
        $dialog->setCurrentItem("Shovel");
        $this->assertSame("Shovel", $dialog->getCurrentItem());
    }

    /**
     * Test get dialog by status
     */
    public function testGetCurrentRoom()
    {
        $dialog = new DialogHandler();
        $dialog->setCurrentRoom("graveyard");
        $this->assertSame("graveyard", $dialog->getCurrentRoom());
    }
}
