<?php

    use BotMan\BotMan\BotMan;
    use BotMan\BotMan\BotManFactory;
    use BotMan\BotMan\Cache\CodeIgniterCache;
    use BotMan\BotMan\Drivers\DriverManager;
    use BotMan\BotMan\Messages\Incoming\Answer;
    use BotMan\BotMan\Messages\Outgoing\Question;
    use BotMan\BotMan\Messages\Outgoing\Actions\Button;
    use BotMan\BotMan\Messages\Conversations\Conversation;
    use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;
    use BotMan\BotMan\Middleware\ApiAi;

class Chatbot extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form','url','check'));
        $this->load->library(array('form_validation','session', 'onboardingconversation', 'productSearch'));
        $this->load->model(array('categories_model', 'chat_model','product_model'));
        
    }

    public function index()
    {

        $data['page'] =  'chatbot';
        $data['title'] = 'Chatbot';
        //$data['email'] = $this->chat_model->findEmail('azizganiyu0@gmail.com');
        $this->load->view('chatbot/header', $data);
        $this->load->view('chatbot/navbar');
        $this->load->view('chatbot/chatbot');
        $this->load->view('chatbot/footer');
    }

    public function widget()
    {
        $data['page'] =  'chatbot';
        $data['title'] = 'Chatbot';
        $data['products'] = $this->product_model->get_featured('4');
        $data['categories'] = $this->categories_model->get_all();
        $this->load->view('chatbot/widget');
    }

    /*public function chat()
    {
        $config = [
            // Your driver-specific configuration
            // "telegram" => [
            //    "token" => "TOKEN"
            // ]
            "conversation_cache_time" => 0
        ];
        
        // Load the driver(s) you want to use
        //DriverManager::loadDriver(\BotMan\Drivers\Telegram\TelegramDriver::class);
        DriverManager::loadDriver(\BotMan\Drivers\Web\WebDriver::class);
        
        $commandsArray = array(
            'show categories',
            'show top {number} products',
            'show products under {category}',
            'show my cart',
            'search {product}',
        );

        $commands = '';
        // Create an instance
        $this->load->driver('cache'); 
        //$botman = BotManFactory::create($config, new CodeIgniterCache($this->cache->file));
        $this->cache->clean();
        $botman = BotManFactory::create($config, new CodeIgniterCache($this->cache->file));
        //$botman = BotManFactory::create($config);

        $botman->hears('.*hi.*|.*sup.*|.*hello.*|.*whats up.*|.*how far.*|.*good day.*', function($bot) {
            $bot->typesAndWaits(2);
            $bot->startConversation($this->onboardingconversation);
        });

        $botman->hears('help', function (BotMan $bot) {
            $bot->reply('Oh, you do need help dont you, these are some of our <b>basic command</b>. you can thank me later.');
            
        });

        $botman->hears('.*thank you.*', function (BotMan $bot) {
            $bot->reply('Oh, you dont have to, just doing my job');
            
        });

        $botman->hears('.*your name.*', function (BotMan $bot) {
            $bot->reply('My name is Gbot');
            
        });

        $badWords = ["4r5e", "5h1t", "5hit", "a55", "anal", "anus", "ar5e", "arrse", "arse", "ass", "ass-fucker", "asses", "assfucker", "assfukka", "asshole", "assholes", "asswhole", "a_s_s", "b!tch", "b00bs", "b17ch", "b1tch", "ballbag", "balls", "ballsack", "bastard", "beastial", "beastiality", "bellend", "bestial", "bestiality", "bi+ch", "biatch", "bitch", "bitcher", "bitchers", "bitches", "bitchin", "bitching", "bloody", "blow job", "blowjob", "blowjobs", "boiolas", "bollock", "bollok", "boner", "boob", "boobs", "booobs", "boooobs", "booooobs", "booooooobs", "breasts", "buceta", "bugger", "bum", "bunny fucker", "butt", "butthole", "buttmuch", "buttplug", "c0ck", "c0cksucker", "carpet muncher", "cawk", "chink", "cipa", "cl1t", "clit", "clitoris", "clits", "cnut", "cock", "cock-sucker", "cockface", "cockhead", "cockmunch", "cockmuncher", "cocks", "cocksuck", "cocksucked", "cocksucker", "cocksucking", "cocksucks", "cocksuka", "cocksukka", "cok", "cokmuncher", "coksucka", "coon", "cox", "crap", "cum", "cummer", "cumming", "cums", "cumshot", "cunilingus", "cunillingus", "cunnilingus", "cunt", "cuntlick", "cuntlicker", "cuntlicking", "cunts", "cyalis", "cyberfuc", "cyberfuck", "cyberfucked", "cyberfucker", "cyberfuckers", "cyberfucking", "d1ck", "damn", "dick", "dickhead", "dildo", "dildos", "dink", "dinks", "dirsa", "dlck", "dog-fucker", "doggin", "dogging", "donkeyribber", "doosh", "duche", "dyke", "ejaculate", "ejaculated", "ejaculates", "ejaculating", "ejaculatings", "ejaculation", "ejakulate", "f u c k", "f u c k e r", "f4nny", "fag", "fagging", "faggitt", "faggot", "faggs", "fagot", "fagots", "fags", "fanny", "fannyflaps", "fannyfucker", "fanyy", "fatass", "fcuk", "fcuker", "fcuking", "feck", "fecker", "felching", "fellate", "fellatio", "fingerfuck", "fingerfucked", "fingerfucker", "fingerfuckers", "fingerfucking", "fingerfucks", "fistfuck", "fistfucked", "fistfucker", "fistfuckers", "fistfucking", "fistfuckings", "fistfucks", "flange", "fook", "fooker", "fuck", "fucka", "fucked", "fucker", "fuckers", "fuckhead", "fuckheads", "fuckin", "fucking", "fuckings", "fuckingshitmotherfucker", "fuckme", "fucks", "fuckwhit", "fuckwit", "fudge packer", "fudgepacker", "fuk", "fuker", "fukker", "fukkin", "fuks", "fukwhit", "fukwit", "fux", "fux0r", "f_u_c_k", "gangbang", "gangbanged", "gangbangs", "gaylord", "gaysex", "goatse", "God", "god-dam", "god-damned", "goddamn", "goddamned", "hardcoresex", "hell", "heshe", "hoar", "hoare", "hoer", "homo", "hore", "horniest", "horny", "hotsex", "jack-off", "jackoff", "jap", "jerk-off", "jism", "jiz", "jizm", "jizz", "kawk", "knob", "knobead", "knobed", "knobend", "knobhead", "knobjocky", "knobjokey", "kock", "kondum", "kondums", "kum", "kummer", "kumming", "kums", "kunilingus", "l3i+ch", "l3itch", "labia", "lust", "lusting", "m0f0", "m0fo", "m45terbate", "ma5terb8", "ma5terbate", "masochist", "master-bate", "masterb8", "masterbat*", "masterbat3", "masterbate", "masterbation", "masterbations", "masturbate", "mo-fo", "mof0", "mofo", "mothafuck", "mothafucka", "mothafuckas", "mothafuckaz", "mothafucked", "mothafucker", "mothafuckers", "mothafuckin", "mothafucking", "mothafuckings", "mothafucks", "mother fucker", "motherfuck", "motherfucked", "motherfucker", "motherfuckers", "motherfuckin", "motherfucking", "motherfuckings", "motherfuckka", "motherfucks", "muff", "mutha", "muthafecker", "muthafuckker", "muther", "mutherfucker", "n1gga", "n1gger", "nazi", "nigg3r", "nigg4h", "nigga", "niggah", "niggas", "niggaz", "nigger", "niggers", "nob", "nob jokey", "nobhead", "nobjocky", "nobjokey", "numbnuts", "nutsack", "orgasim", "orgasims", "orgasm", "orgasms", "p0rn", "pawn", "pecker", "penis", "penisfucker", "phonesex", "phuck", "phuk", "phuked", "phuking", "phukked", "phukking", "phuks", "phuq", "pigfucker", "pimpis", "piss", "pissed", "pisser", "pissers", "pisses", "pissflaps", "pissin", "pissing", "pissoff", "poop", "porn", "porno", "pornography", "pornos", "prick", "pricks", "pron", "pube", "pusse", "pussi", "pussies", "pussy", "pussys", "rectum", "retard", "rimjaw", "rimming", "s hit", "s.o.b.", "sadist", "schlong", "screwing", "scroat", "scrote", "scrotum", "semen", "sex", "sh!+", "sh!t", "sh1t", "shag", "shagger", "shaggin", "shagging", "shemale", "shi+", "shit", "shitdick", "shite", "shited", "shitey", "shitfuck", "shitfull", "shithead", "shiting", "shitings", "shits", "shitted", "shitter", "shitters", "shitting", "shittings", "shitty", "skank", "slut", "sluts", "smegma", "smut", "snatch", "son-of-a-bitch", "spac", "spunk", "s_h_i_t", "t1tt1e5", "t1tties", "teets", "teez", "testical", "testicle", "tit", "titfuck", "tits", "titt", "tittie5", "tittiefucker", "titties", "tittyfuck", "tittywank", "titwank", "tosser", "turd", "tw4t", "twat", "twathead", "twatty", "twunt", "twunter", "v14gra", "v1gra", "vagina", "viagra", "vulva", "w00se", "wang", "wank", "wanker", "wanky", "whoar", "whore", "willies", "willy", "xrated", "xxx"];
        $len = count($badWords) - 1;
        for($i = 0; $i<=$len; $i++)
        {
            $botman->hears($badWords[$i], function (BotMan $bot) {
                $badWordsReply = ["Please dont curse", "Sorry we dont do that here", "Take that back", "You think you are responsible?", "Stop that, or I will unregister you. yes, unregister you", "Is that how you speak to your Mama?"];
                $randReplyCount = count($badWordsReply);
                $bot->reply($badWordsReply[rand(0,$randReplyCount)]);
                
            });
        }

        $botman->fallback(function(BotMan $bot) {
            $bot->reply('Sorry, I did not understand these commands');   
        });
        // Start listening
        $botman->listen();
    }*/
    public function chat()
    {
        $config = [
            // Your driver-specific configuration
            // "telegram" => [
            //    "token" => "TOKEN"
            // ]
            'conversation_cache_time' => 2
        ];
        
        // Load the driver(s) you want to use
        //DriverManager::loadDriver(\BotMan\Drivers\Telegram\TelegramDriver::class);
        DriverManager::loadDriver(\BotMan\Drivers\Web\WebDriver::class);
        
        $commandsArray = array(
            'show categories',
            'show top {number} products',
            'show products under {category}',
            'show my cart',
            'search {product}',
        );

        $commands = '';
        // Create an instance
        $this->load->driver('cache');
        $this->cache->clean();
        $botman = BotManFactory::create($config, new CodeIgniterCache($this->cache->file));
        
        $this->cache->clean();
        //$botman = BotManFactory::create($config);

        $dialogflow = ApiAi::create('881021a596c8467eb06b4a0baaeb5a21')->listenForAction();
        $botman->middleware->received($dialogflow);
        $botman->hears('input.welcome', function (BotMan $bot) {
            
            $extras = $bot->getMessage()->getExtras();
            $apiReply = $extras['apiReply'];
            $apiAction = $extras['apiAction'];
            $apiIntent = $extras['apiIntent'];
            
            $bot->reply($apiReply);
            
        })->middleware($dialogflow);

        $botman->hears('smalltalk.*', function (BotMan $bot) {
            
            $extras = $bot->getMessage()->getExtras();
            $apiReply = $extras['apiReply'];
            $apiAction = $extras['apiAction'];
            $apiIntent = $extras['apiIntent'];
            
            $bot->reply($apiReply);
            
        })->middleware($dialogflow);

        $botman->hears('product.search.*', function (BotMan $bot) {
            
            $extras = $bot->getMessage()->getExtras();
            $apiReply = $extras['apiReply'];
            $apiAction = $extras['apiAction'];
            $apiIntent = $extras['apiIntent'];
            $apiParam = $extras['apiParameters'];
            $apiParams = json_encode($extras['apiParameters']);

            //$bot->reply($apiReply);
            $chat_search = array(
                'chat_product_search' => isset($apiParam['product'])? $apiParam['product'] : 'undefined',
                'chat_category_search' => isset($apiParam['category'])? $apiParam['category'] : 'undefined',
            );

            $this->session->set_userdata($chat_search);

            $bot->startConversation($this->productsearch);
            
           // $bot->reply($apiParams);
            
        })->middleware($dialogflow);

        $botman->hears('i want to buy samsung laptop', function($bot) {
            $apiParam = array();
            $this->load->library("productsearch", $apiParam);
            $bot->startConversation($this->productsearch);
        });

        $botman->fallback(function(BotMan $bot) {
            $fallbacks = [
                "Sorry, I dont understand",
            ];
            $bot->reply($fallbacks[rand(0,count($fallbacks) - 1)]);   
        });
        // Start listening
        $botman->listen();
    }

}