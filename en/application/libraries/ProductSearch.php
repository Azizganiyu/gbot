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
    use BotMan\BotMan\Messages\Attachments\Image;



class ProductSearch extends Conversation
{
    //protected $params;

    protected $search;

    protected $search_count;

    protected $current_index = 0;

    public function __construct()
    {
        //$this->category = "laptops";
        //$this->product = "undefined";
    }

    public function test()
    {
        $this->say(isset($_SESSION['chat_category_search'])? $_SESSION['chat_category_search'] : 'undefined');
    }
    public function showProduct()
    {
            $category = isset($_SESSION['chat_category_search'])? $_SESSION['chat_category_search'] : 'undefined';
            $product = isset($_SESSION['chat_product_search'])? $_SESSION['chat_product_search'] : 'undefined';
            //$link = json_encode($this->params);
            $CI =& get_instance();
            $CI->load->model(array('chat_model',));
            $search = $CI->chat_model->searchProduct($category, $product);
            if($search)
            {
                $this->search = $search;
                $this->search_count = count($search['result']);
                
                    $attachment = new Image($search['result'][$this->current_index]['image']);
                    $message = OutgoingMessage::create($search['result'][$this->current_index]['name'].' - ₦'.$search['result'][$this->current_index]['price'])->withAttachment($attachment);
                    $this->say($message);

                    if($this->search_count > 1)
                    {
                        $this->GetMoreProduct();
                    }
                    else
                    {
                        $this->say('This is the only product I could find based on your search');
                        $this->askCart();
                    }
            
            }
            else
            {
                $this->say('Sorry, we dont have this product');
            }
            
    }

    public function askCart()
    {
        $cart = Question::create('Do you want me to add this product to cart?')
            ->addButtons([
                Button::create('Yes')->value('yes'),
                Button::create('No')->value('no'),
            ]);
                        
        $this->ask($cart, [
            [
                'pattern' => 'yes|yep|yea|ofcus|sure|yeah|definately|ok|yap',
                'callback' => function () {
                    $CI =& get_instance();
                    $CI->load->model(array('chat_model',));
                    $CI->chat_model->addCart($this->search['result'][$this->current_index]['id'], 1, 1);
                    $this->say('Added to cart');
                }
            ],
            [
                'pattern' => 'nah|no|nope|not now',
                'callback' => function () {
                    $this->say('what more can i do for you?');
                }
            ]
        ]);
    }

    public function GetMoreProduct()
    {
        $question = Question::create('Do you want to see more?')
            ->addButtons([
                Button::create('Yes')->value('yes'),
                Button::create('No')->value('no'),
            ]);

        
            $this->ask($question, [
                [
                    'pattern' => 'yes|yep|yea|ofcus|sure|yeah|definately|ok',
                    'callback' => function () {
                        $this->NextProduct($this->current_index + 1);
                    }
                ],
                [
                    'pattern' => 'nah|no|nope|not now',
                    'callback' => function () {
                        $this->askCart();
                    }
                ]
            ]);
    }

    public function NextProduct($index)
    {
        $this->current_index = $index;
        $attachment = new Image($this->search['result'][$index]['image']);
        $message = OutgoingMessage::create($this->search['result'][$this->current_index]['name'].' - ₦'.$this->search['result'][$this->current_index]['price'])->withAttachment($attachment);
        $this->say($message);
        if($index > 0 &&  $index < $this->search_count - 1)
        {
            $question = Question::create('')
            ->addButtons([
                Button::create('Add to cart')->value('cart'),
                Button::create('Next')->value('next'),
                Button::create('Previous')->value('prev'),
            ]);

            $this->ask($question, [
                [
                    'pattern' => 'cart|add to cart|add this to cart|i want this one|select this one|choose this|i want this|select this|add product to cart|cart product|i want this product|select this product| choose this product',
                    'callback' => function () {
                        $CI =& get_instance();
                        $CI->load->model(array('chat_model',));
                        $CI->chat_model->addCart($this->search['result'][$this->current_index]['id'], 1, 1);
                        $this->say('Added to cart');
                    }
                ],
                [
                    'pattern' => 'next|next one|nxt|forward|front',
                    'callback' => function () {
                        $this->NextProduct($this->current_index + 1);
                    }
                ],
                [
                    'pattern' => 'previous|prev|back|backwards|backward',
                    'callback' => function () {
                        $this->prevProduct($this->current_index - 1);
                    }
                ]
            ]);
        }
        elseif($index == 0)
        {
            $question = Question::create('')
            ->addButtons([
                Button::create('Add to cart')->value('cart'),
                Button::create('Next')->value('next'),
            ]);

            $this->ask($question, [
                [
                    'pattern' => 'cart|add to cart|add this to cart|i want this one|select this one|choose this|i want this|select this|add product to cart|cart product|i want this product|select this product| choose this product',
                    'callback' => function () {
                        $CI =& get_instance();
                        $CI->load->model(array('chat_model',));
                        $CI->chat_model->addCart($this->search['result'][$this->current_index]['id'], 1, 1);
                        $this->say('Added to cart');
                    }
                ],
                [
                    'pattern' => 'next|next one|nxt|forward|front',
                    'callback' => function () {
                        $this->NextProduct($this->current_index + 1);
                    }
                ],
            ]);
        }
        else
        {
            $question = Question::create('')
            ->addButtons([
                Button::create('Add to cart')->value('cart'),
                Button::create('Previous')->value('prev'),
            ]);

            $this->ask($question, [
                [
                    'pattern' => 'cart|add to cart|add this to cart|i want this one|select this one|choose this|i want this|select this|add product to cart|cart product|i want this product|select this product| choose this product',
                    'callback' => function () {
                        $CI =& get_instance();
                        $CI->load->model(array('chat_model',));
                        $CI->chat_model->addCart($this->search['result'][$this->current_index]['id'], 1, 1);
                        $this->say('Added to cart');
                    }
                ],
                [
                    'pattern' => 'next|next one|nxt|forward|front',
                    'callback' => function () {
                        $this->say('No more product, view previous ones');
                        $this->NextProduct($this->current_index + 1);
                    }
                ],
                [
                    'pattern' => 'previous|prev|back|backwards|backward',
                    'callback' => function () {
                        $this->PrevProduct($this->current_index - 1);
                    }
                ]
            ]);
        }
    }

    public function prevProduct($index)
    {
        $this->current_index = $index;
        $attachment = new Image($this->search['result'][$index]['image']);
        $message = OutgoingMessage::create($this->search['result'][$this->current_index]['name'].' - ₦'.$this->search['result'][$this->current_index]['price'])->withAttachment($attachment);
        $this->say($message);
        if($index > 0 && $index < $this->search_count - 1)
        {
            $question = Question::create('')
            ->addButtons([
                Button::create('Add to cart')->value('cart'),
                Button::create('Next')->value('next'),
                Button::create('Previous')->value('prev'),
            ]);

            $this->ask($question, [
                [
                    'pattern' => 'cart|add to cart|add this to cart|i want this one|select this one|choose this|i want this|select this|add product to cart|cart product|i want this product|select this product| choose this product',
                    'callback' => function () {
                        $CI =& get_instance();
                        $CI->load->model(array('chat_model',));
                        $CI->chat_model->addCart($this->search['result'][$this->current_index]['id'], 1, 1);
                        $this->say('Added to cart');
                    }
                ],
                [
                    'pattern' => 'next|next one|nxt|forward|front',
                    'callback' => function () {
                        $this->NextProduct($this->current_index + 1);
                    }
                ],
                [
                    'pattern' => 'previous|prev|back|backwards|backward',
                    'callback' => function () {
                        $this->PrevProduct($this->current_index - 1);
                    }
                ]
            ]);
        }
        elseif($index == 0)
        {
            $question = Question::create('')
            ->addButtons([
                Button::create('Add to cart')->value('cart'),
                Button::create('Next')->value('next'),
            ]);

            $this->ask($question, [
                [
                    'pattern' => 'cart|add to cart|add this to cart|i want this one|select this one|choose this|i want this|select this|add product to cart|cart product|i want this product|select this product| choose this product',
                    'callback' => function () {
                        $CI =& get_instance();
                        $CI->load->model(array('chat_model',));
                        $CI->chat_model->addCart($this->search['result'][$this->current_index]['id'], 1, 1);
                        $this->say('Added to cart');
                    }
                ],
                [
                    'pattern' => 'next|next one|nxt|forward|front',
                    'callback' => function () {
                        $this->NextProduct($this->current_index + 1);
                    }
                ],
            ]);
        }
        else
        {
            $question = Question::create('')
            ->addButtons([
                Button::create('Add to cart')->value('cart'),
                Button::create('Previous')->value('prev'),
            ]);

            $this->ask($question, [
                [
                    'pattern' => 'cart|add to cart|add this to cart|i want this one|select this one|choose this|i want this|select this|add product to cart|cart product|i want this product|select this product| choose this product',
                    'callback' => function () {
                        $CI =& get_instance();
                        $CI->load->model(array('chat_model',));
                        $CI->chat_model->addCart($this->search['result'][$this->current_index]['id'], 1, 1);
                        $this->say('Added to cart');
                    }
                ],
                [
                    'pattern' => 'next|next one|nxt|forward|front',
                    'callback' => function () {
                        $this->say('No more product, view previous ones');
                    }
                ],
                [
                    'pattern' => 'previous|prev|back|backwards|backward',
                    'callback' => function () {
                        $this->PrevProduct($this->current_index - 1);
                    }
                ]
            ]);
        }
    }
    public function run()
    {
        // This will be called immediately
        //$this->test();
        $this->showProduct();
    }
}
