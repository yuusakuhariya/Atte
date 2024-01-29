# アプリケーション名
Atte（勤怠管理システム）
![スクリーンショット 2024-01-29 063454](https://github.com/yuusakuhariya/Atte/assets/137383906/46250c53-df24-4b2c-9b67-d46906c403a8)


## 作成した目的
* 人事評価のため


## アプリケーションURL
* 


## 機能一覧
* メールアドレス、パスワードでのログイン
* 名前、メールアドレス、パスワードの新規登録
* 出勤記録、退勤記録
* 休憩開始、休憩終了の複数回記録
* 1日の出勤時間計算、1日の休憩時間計算
* 指定日の各ユーザーの勤務記録の表示

## 使用技術
*Laravel 8.83.8
* Docker 3.8
* nginx 1.21.1
* php 
* mysql 8.0.26
* phpmyadmin


## テーブル設計
![スクリーンショット 2024-01-29 074020](https://github.com/yuusakuhariya/Atte/assets/137383906/d0280df1-4c05-4944-9574-2cb8bb0a0e6d)


## ER図
![スクリーンショット 2024-01-29 073754](https://github.com/yuusakuhariya/Atte/assets/137383906/81b8bd04-7a63-41d1-abef-77b79c871a4c)


## 環境構築
* 概要
  * LaravelをDockerで動作させ、NginxでWebサーバーを構築し、PHPMyAdminでデータベースを管理するための手順。
* 以下のソフトウェアがインストールされていることを確認。
  * Docker (https://www.docker.com/)
  * Docker-compose (https://docs.docker.com/compose/)
* プロジェクトのクローン。
  * git clone https://github.com/yuusakuhariya/Atte.git
* env ファイル作成し、環境設定実行。
  * cp .env.example .env
* Dockerコンテナをビルドして起動する。
  * docker-compose up -d --build
* Laravelアプリケーションをインストールし、アプリケーションキーを生成する。
  * docker-compose exec app composer install
  * docker-compose exec app php artisan key:generate
* データベースのマイグレーションを実行する。
  * docker-compose exec app php artisan migrate
* http://localhost にアクセスしてLaravelアプリケーションにアクセスできることを確認する。
* http://localhost:8080 にアクセスしてPhpMyAdminでデータベースを管理できることを確認する。


## 他記載内容
