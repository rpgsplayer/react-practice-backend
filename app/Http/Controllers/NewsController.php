<?php

namespace App\Http\Controllers;

use App\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NewsController extends Controller
{
    public function insert() {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.nytimes.com/svc/search/v2/articlesearch.json?q=phone&page=26&api-key=KsdfvHToa9hWIQsHODbOE6to5Vs97EeN");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
    	$output = json_decode($output, true);

    	foreach ($output['response']['docs'] as $doc) {
    		$news = new News;
    		$news->headline = $doc['headline']['main'];
    		$news->abstract = $doc['abstract'];
    		$news->url = $doc['web_url'];
    		$news->save();
    	}

    	return ['success' => true];

    }

    public function get() {
        $news = app('db')->table('news')->paginate(15);
        return $news;
    }
}
