<?php

# Behavioral Design Pattern: Observer

interface ISubject {
    public function attach(IObserver $observer);
    public function detach(IObserver $observer);
    public function notify($event, $data);
}

?>

