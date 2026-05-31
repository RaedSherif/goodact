<?php

# Behavioral Design Pattern: Observer

interface IObserver
{
    public function update($event, $data);
}
