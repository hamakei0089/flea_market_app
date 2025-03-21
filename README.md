# coachtechフリマ

ある企業が開発した独自のフリマアプリ

## 作成した目的

アイテムの出品と購入を行うためのフリマアプリを開発する

## アプリケーションのURL

## 他のリポジトリ

https://github.com/hamakei0089/flea_market_app.git

## 機能一覧

会員登録　　

ログイン機能　　

メール認証機能　　

ユーザー情報取得　　

ユーザープロフィール情報の編集　　

商品一覧取得　　

商品詳細取得　　

商品名検索機能　　

商品購入機能　　

商品出品機能　　

商品へのいいね追加　　

商品へのいいね削除　　

商品へのコメント取得　　

商品へのコメント追加機能　　

出品者との取引チャット機能　　

取引チャットの編集・削除機能　　

取引チャット後のユーザー評価機能　　

## 使用技術（実行環境）

PHP 8.3.16　　

Laravel Framework  10.48.23　　

MySQL8.1　　

## テーブル設計

![Alt text](table1.png)　　
![Alt text](table2.png)　　
![Alt text](table3.png)　　
![Alt text](table4.png)　　

## ER図

![Alt text](ER.png)  

# 環境構築


Dockerビルド

1. git clone git@github.com:hamakei0089/flea_market_app.git　　

2. DockerDesktopを立ち上げる　　

3. docker-compose up -d 　　

Laravel環境構築　　

1. docker-compose exec php bash　　

2. composer install　　

3. composer require laravel/fortify　　

4. 支払い機能にstripeを使用するため、以下のコマンドを入力

composer require stripe/stripe-php　　

config/service.phpに以下を追加　　

    'stripe' => [
        'secret' => env('STRIPE_SECRET'),
        'public' => env('STRIPE_PUBLIC'),
    ],


5. test実行のため、以下のコマンドを入力

composer require --dev laravel/dusk　　

php artisan dusk:install　　


5. 「.env.example」ファイルを「.env」ファイルに命名を変更　　

6. .envに以下の環境変数を変更　　

APP_NAME=coachtech_flea_ma_app　　

DB_HOST=mysql　　

DB_DATABASE=your_db_name　　

DB_USERNAME=your_db_user　　

DB_PASSWORD=your_db_password　　

MAIL_HOST=mail　　

MAIL_FROM_ADDRESS="flea_ma@example.com"　　

MAIL_FROM_NAME="coachtech_flea_ma"　　

STRIPE_PUBLIC=your_stripe_public_key　　

STRIPE_SECRET=your_stripe_secret_key　　

7. アプリケーションキーの作成　　

php artisan key:generate　　

8. マイグレーションの実行　　

php artisan migrate　　

9. シンボリックリンクの作成

php artisan storage:link　　

10. ダミーデータのシーディング　　

開発環境で使用するための商品データ、ユーザーのダミーデータをデータベースに投入　　

php artisan db:seed　　

※ここで追加したユーザーデータは3つあります。追加した商品データ10個の内、ユーザーデータ2つをそれぞれ商品5つずつ紐づけており、残り1つのユーザーデータは何も紐付けをしていません。

# coachtechフリマ






