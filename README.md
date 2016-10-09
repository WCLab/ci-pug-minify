If you are not replacing files:

Add vendor autoload to CI index.php
Add core/MY_Loader.php to {app}/core
Add Jade library to your app libraries

If not add pug class extending jade, use jade instead pug.


Use:

$options = array(
    /* View more about pug configs */
    "enviroment" => "development", //development as default
    "assetDirectory" => "assets", //dev as default
    "outputDirectory" => "static", //public as default
);

$this->load->library("jade",$options);

$data = array();

Jade library works similar to parser

#Parsing multiple views in another view
$module["content"] = $this->jade->view("index",$data,true);
$this->jade->view("template",array_merge($data,$module));

#Loading a simple view
$this->jade->view("privacy_notice");

#Without params print a view named identical to method 
// 1.- {app}/views/{method}
// 2.- {app}/views/{class}/{method}

$this->jade->view();
$this->jade->view($data);

//Same to
$this->jade->view($data,true);

