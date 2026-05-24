<?php
interface IObserver
{
    public function update($event, $data);
}
