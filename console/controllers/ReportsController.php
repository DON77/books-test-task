<?php

namespace console\controllers;

use common\models\OrderItems;
use Yii;
use yii\console\Controller;

class ReportsController extends Controller {

    public function actionSend($to) {
        $getMostSoldBooks = OrderItems::find()->select('book_id, count(book_id) as `count`')->groupBy('book_id')->orderBy(['count(book_id)' => SORT_DESC])->limit(5)->all();
        $mostSoldBooks = [];
        foreach ($getMostSoldBooks as $book) {
            $mostSoldBooks[] = $book->book->title;
        }

        $mostSoldAuthorsCounts = [];
        $mostSoldBooksNames = [];
        $mostSoldAuthorsNames = [];
        $mostSoldAuthorsPrices = [];
        $mostSoldBooksPrices = [];
        $mostSoldAuthors = [];
        $getMostSoldAuthorsBooks = OrderItems::find()->all();
        foreach ($getMostSoldAuthorsBooks as $authorBook) {
            $mostSoldBooksNames[$authorBook->book->id] = $authorBook->book->title;
            $mostSoldBooksPrices[$authorBook->book->id] = isset($mostSoldBooksPrices[$authorBook->book->id]) ? $mostSoldBooksPrices[$authorBook->book->id] + $authorBook->book->price : $authorBook->book->price;
            foreach ($authorBook->book->authors as $author) {
                $mostSoldAuthorsNames[$author['id']] = $author->first_name . ' ' . $author->middle_name . ' ' . $author->last_name;
                $mostSoldAuthorsCounts[$author['id']] = isset($mostSoldAuthorsCounts[$author['id']]) ? $mostSoldAuthorsCounts[$author['id']] + 1 : 1;
                $mostSoldAuthorsPrices[$author['id']] = isset($mostSoldAuthorsPrices[$author['id']]) ? $mostSoldAuthorsPrices[$author['id']] + $authorBook->book->price : $authorBook->book->price;
            }
        }

        arsort($mostSoldAuthorsCounts);
        $newMostSoldAuthorsCounts = array_slice($mostSoldAuthorsCounts, 0, 5, true);
        foreach ($newMostSoldAuthorsCounts as $key => $value) {
            $mostSoldAuthors[] = $mostSoldAuthorsNames[$key];
        }

        $mostProfitableBooks = [];
        arsort($mostSoldBooksPrices);
        $newMostSoldBooksPrices = array_slice($mostSoldBooksPrices, 0, 5, true);
        foreach ($newMostSoldBooksPrices as $key => $value) {
            $mostProfitableBooks[] = $mostSoldBooksNames[$key];
        }

        $mostProfitableAuthors = [];
        arsort($mostSoldAuthorsPrices);
        $newMostSoldAuthorsPrices = array_slice($mostSoldAuthorsPrices, 0, 5, true);
        foreach ($newMostSoldAuthorsPrices as $key => $value) {
            $mostProfitableAuthors[] = $mostSoldAuthorsNames[$key];
        }

        $text = '<table style="border: 1px solid black;" cellspacing="0"><caption>Most Sold Books</caption>';
        foreach ($mostSoldBooks as $book) {
            $text .= '<tr><td style="border: 1px solid black;">' . $book . '</td></tr>';
        }
        $text .= '</table>';

        $text .= '<table style="border: 1px solid black;" cellspacing="0"><caption>Most Sold Authors</caption>';
        foreach ($mostSoldAuthors as $author) {
            $text .= '<tr><td style="border: 1px solid black;">' . $author . '</td></tr>';
        }
        $text .= '</table>';

        $text .= '<table style="border: 1px solid black;" cellspacing="0"><caption>Most Profitable Books</caption>';
        foreach ($mostProfitableBooks as $book) {
            $text .= '<tr><td style="border: 1px solid black;">' . $book . '</td></tr>';
        }
        $text .= '</table>';

        $text .= '<table style="border: 1px solid black;" cellspacing="0"><caption>Most Profitable Authors</caption>';
        foreach ($mostProfitableAuthors as $author) {
            $text .= '<tr><td style="border: 1px solid black;">' . $author . '</td></tr>';
        }
        $text .= '</table>';

        Yii::$app->mail->compose()
                ->setFrom('email@example.com')
                ->setTo($to)
                ->setSubject('Statistics')
                ->setHtmlBody($text)
                ->send();
    }

}
