<?php


namespace App\Contracts;


interface TokenContract
{
    public function make_token(int $id) : string;
    public function get_token(int $id) : string;
}
