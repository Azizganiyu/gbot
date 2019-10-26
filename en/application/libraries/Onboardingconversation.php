<?php

defined('BASEPATH') OR exit('No direct script access allowed');
    
    use BotMan\BotMan\BotMan;
    use BotMan\BotMan\BotManFactory;
    use BotMan\BotMan\Cache\CodeIgniterCache;
    use BotMan\BotMan\Drivers\DriverManager;
    use BotMan\BotMan\Messages\Incoming\Answer;
    use BotMan\BotMan\Messages\Outgoing\Question;
    use BotMan\BotMan\Messages\Outgoing\Actions\Button;
    use BotMan\BotMan\Messages\Conversations\Conversation;
    use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;



class Onboardingconversation extends Conversation
{
    protected $fullname;

    protected $email;

    public function askfullname()
    {
        $this->ask('Hello! May i know your full name?', function(Answer $answer) {
            // Save result
            $this->fullname = $answer->getText();

            $this->say('Nice to meet you '.$this->fullname);
            $this->askEmail();
        });
    }

    public function askEmail()
    {
        $this->ask('One more thing - what is your email?', function(Answer $answer) {
            // Save result
            $this->email = $answer->getText();

            $this->validateEmail();

        });
    }

    public function validateEmail()
    {
        if(filter_var($this->email, FILTER_VALIDATE_EMAIL))
        {
            $this->say('Great - that is all we need, '.$this->fullname);
            $this->userExist();
        }
        else
        {
            $this->askEmailAgain();
        }
    }

    public function askEmailAgain()
    {
        $this->ask('The email address you have provided is not correct, please check the email and try again', function(Answer $answer) {
            // Save result
            $this->email = $answer->getText();

            $this->validateEmail();

        });
    }

    public function userExist()
    {
        $CI =& get_instance();
        $CI->load->model(array('chat_model',));
        $check = $CI->chat_model->findEmail($this->email);
        if($check)
        {
            $this->ask('Seems you are registered with us already. Do you want me to log you in?', function(Answer $answer) {
                // Save result
                if($answer->getText() == 'yes')
                {
                    $this->say('I will log you in now');
                    $this->login();
                }
                elseif($answer->getText() == 'no')
                {
                    $this->say('ok lets go on');
                    $this->say($this->fullname.' how can i help you today?');
                }
                else
                {
                    $this->say('I was expecting a yes or no reply');
                    $this->userExist();
                }
    
            });
        }
        else
        {
            $this->say('You are currently not registered with us');
            $this->askRegister();
        }
    }

    public function askRegister()
    {
        $this->ask('Do you want to register with us now?', function(Answer $answer) {
            // Save result
            if($answer->getText() == 'yes')
            {
                $this->say('I will register you now');
                $this->register();
            }
            elseif($answer->getText() == 'no')
            {
                $this->say('ok lets go on');
                $this->say($this->fullname.' how can i help you today?');
            }
            else
            {
                $this->say('I was expecting a yes or no reply');
                $this->askRegister();
            }

        }); 
    }

    public function register()
    {
        $this->ask('Please choose a prefered password, make sure its at least 8 characters in length', function(Answer $answer) {
            // Save result
            $CI =& get_instance();
            $CI->load->model(array('chat_model',));
            $password = $answer->getText();
            $password = htmlspecialchars(trim($password));
            if(strlen($password) >= 8)
            {
                if( $CI->chat_model->register($this->fullname, $this->email, $password))
                {
                    $this->say('Welcome aboard, you have been registered and also logged in!');
                    $this->say($this->fullname.' how can i help you today?');
                }
                else
                {
                    $this->say('Something not goo happened, we will try and register you later');
                }
            }
            else
            {
                $this->say('Your password lenth is less than 8');
                $this->register();
            }

        });
    }

    public function login()
    {

        $this->ask('Please give me your password', function(Answer $answer) {
            // Save result
            $CI =& get_instance();
            $CI->load->model(array('chat_model',));
            if( $CI->chat_model->login($this->email, $answer->getText()))
            {
                $this->say('I have successfully logged you in');
                $this->say($this->fullname.' how can i help you today?');
            }
            else
            {
                $this->say('Your password is not correct please check and try again');
                $this->reLogin();
            }

        });
    }

    public function reLogin()
    {

        $this->ask('Please enter password again', function(Answer $answer) {
            // Save result
            $CI =& get_instance();
            $CI->load->model(array('chat_model',));
            if( $CI->chat_model->login($this->email, $answer->getText()))
            {
                $this->say('I have successfully logged you in');
                $this->say($this->fullname.' how can i help you today?');
            }
            else
            {
                $this->say('Your password is not correct please check and try again');
                $this->reLogin();
            }

        });
    }

    public function run()
    {
        // This will be called immediately
        $this->askfullname();
    }
}
