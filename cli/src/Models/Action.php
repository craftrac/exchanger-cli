<?php
namespace Exchanger\Models;


interface Action
{
    // Execute the action
    public function execute();
    // Prepare the data for a specific purpose (such as db insertion)
    public function prepare();
}


