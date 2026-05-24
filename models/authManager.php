<?php
require_once __DIR__ . '/../interfaces/IAuth.php';
require_once __DIR__ . '/../interfaces/IObserver.php';
require_once __DIR__ . '/../interfaces/ISubject.php';
require_once __DIR__ . '/User.php';

class AuthManager implements IAuth, ISubject
{

    private $user;      
    private $action;    
    private $observers = [];

    public function __construct(User $user, $action)
    {
        $this->user   = $user;
        $this->action = $action;
    }

    public function execute($data)
    {
        if ($this->action == "register") {
            $result = $this->user->register($data);
            $event  = $result ? "user_registered" : "register_failed";
        } else {
            $result = $this->user->login($data);
            $event  = $result ? "user_loggedin" : "login_failed";
        }

        $this->notify($event, $data['email']);
        return $result;
    }

    public function attach(IObserver $observer)
    {
        $this->observers[] = $observer;
    }

    public function detach(IObserver $observer)
    {
        $this->observers = array_filter(
            $this->observers,
            fn($o) => $o !== $observer
        );
    }

    public function notify($event, $data)
    {
        foreach ($this->observers as $observer) {
            $observer->update($event, $data);
        }
    }
}
