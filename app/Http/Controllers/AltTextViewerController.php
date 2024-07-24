<?php

namespace App\Http\Controllers;

use EasyWiki;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class AltTextViewerController extends Controller
{
    public function index()
    {
        return view('AltTextViewer.index');
    }

    public function submit()
    {
        $data["page"] = request('page');
        $mode = request('mode');
        if($mode != "wikitext" && $mode != "html") {
            throw new BadRequestException("Invalid mode");
        }

        if($mode != "wikitext") {
            $data["mode"] = $mode;
        }
        return redirect()->route('alttextviewer.result', $data);
    }

    public function view($page) {
        $mode = request('mode', 'wikitext');
        // TODO: THIS
        $url = "https://en.wikipedia.org";
        $wiki = new EasyWiki("$url/w/api.php");
        $media = [];

        if($mode == "wikitext") {
            $wikitext = $wiki->getWikitext($page);
            $lines = explode("\n", $wikitext);
            foreach ($lines as $line) {
                preg_match("/(\[\[File:.*]])/i", $line, $matches);
                if (count($matches) > 0) {
                    if (preg_match("/file:(.*?)[\|\]]/i", $matches[1], $fileNameMatches)) {
                        $fileName = $fileNameMatches[1];
                    } else {
                        continue;
                    }

                    $alt = "";
                    if (preg_match("/alt=(.*?)[\|\]]/i", $matches[1], $altMatches)) {
                        $alt = $altMatches[1];
                    };

                    $media[$fileName] = $alt;
                }
            }
        }
        elseif($mode == "html") {
            $rendered = $wiki->getHTML($page);

            $lines = explode("\n", $rendered);

            foreach($lines as $line) {
                preg_match("/(<img.*?>)/i", $line, $matches);
                if (count($matches) > 0) {
                    if (preg_match("/src=\"(.*?)\"/i", $matches[1], $srcMatches)) {
                        $urlParts = parse_url($srcMatches[1]);
                        $filename = basename($urlParts['path']);
                        $filename = preg_replace("/^\d+px-/", "", $filename);
                        $filename = preg_replace("/.svg.*$/", ".svg", $filename);
                        $filename = urldecode($filename);
                        $filename = str_replace("_", " ", $filename);
                        if (isset($media[$filename])) {
                            continue;
                        }
                    } else {
                        continue;
                    }

                    $alt = "";
                    if (preg_match("/alt=\"(.*?)\"/i", $matches[1], $altMatches)) {
                        $alt = $altMatches[1];
                    };

                    $media[$filename] = $alt;
                }
            }
        }
        else{
            throw new BadRequestException("Invalid mode");
        }

        return view('AltTextViewer.result', [
            'media' => $media,
            'wikiURL' => $url,
            'pageTitle' => $page,
        ]);
    }
}
