
# ■Laravel+Vue環境構築

## 前提
<code>$</code>はホストマシンのbash<br/>
<code>#</code>はコンテナ内のbash<br/>
docker-compose.ymlのある階層でdockerコマンドを入力してください。

## ☆手順
### Dockerをインストールする
→インストールされている方はスキップして下さい

・インストール手順
https://qiita.com/kurkuru/items/127fa99ef5b2f0288b81

```
// brewの人はこちら
brew cask install docker
```

### プロジェクトクローンする
```
git clone origin https://github.com/sgash708/CreatingLaravel.git
cd CreatingLaravel
```

### Dockerで環境作成(php,mysql,nginxの構成)
```
/*
 ".env"をコピーして好きなように使ってください。
 今回はDB設定に使っています。
 */
$ cp .env-sample .env

// Laravelのプロジェクトを配置するディレクトリ
$ mkdir server

// イメージ作成 & コンテナ作成 & コンテナ起動
$ docker-compose up -d
```

### Laravel プロジェクト作成
Laravel8系の人向けに、JetStreamを追加しました。
→<code>laravel/ui</code>と同じ機能です。

```
// コンテナにログイン
$ docker exec -it コンテナ名(今回は'php_sample') bash

/*
 versionは指定しなくてもOKです。
 その場合、"laravel/laravel"でOK
 */
# composer create-project "laravel/laravel=バージョン" .

// Laravelのバージョン確認
# php artisan --version

// composer.jsonをアップデートします
# composer update

// (version8) !!JetStreamを入れます!!
# composer require laravel/jetstream
# php artisan  jetstream:install livewire
# npm install && npm run dev
# php artisan migrate
// (version8) !!JetStreamを入れました!!
```

導入後よくあるエラーです。
https://laracasts.com/discuss/channels/laravel/laravel-8-jetstream-livewire-inertia-error

### vueJSインストール(GitCloneしたら必ずやる！)
```
// インストール例
# npm install vue axios
# npm install
```

### DB設定(server/.env作成→修正)
```
DB_CONNECTION=mysql
DB_HOST=docker-compose.ymlで定義したコンテナ名
DB_PORT=3306
DB_DATABASE=docker-compose.ymlで定義したデータベース
DB_USERNAME=docker-compose.ymlで定義したユーザ名
DB_PASSWORD=docker-compose.ymlで定義したパスワード
```

### アプリキー作成
```
# php artisan key:generate
# php artisan config:clear
```

## ☆Dockerコマンドについて
Dockerを初めて使う人向け用におまけです。
イメージを使用してコンテナを作成します。ですので削除する場合の手順はコンテナ→イメージの順でお願いします。

```
/* 
 開始
 -d はデタッチモード(バックグラウンド)で起動
 */
$ docker-compose up -d

/* 
 終了
 down でコンテナ終了と削除を行う
 */
$ docker-compose down

/* 
 コンテナにログイン
 phpのコンテナ名を入力する
 */

$ docker exec -it コンテナ名 bash

/* 
 イメージ確認
 ホストマシン内のイメージを全て確認する
 */
$ docker images

/* 
 コンテナ確認
 ホストマシン内のコンテナを全て確認する
 ※ -a で起動していないものを確認できる
 */
$ docker ps -a

/* 
 連携コンテナ確認
 ホストマシン内の連携しているコンテナを全て確認する
 ※ -a で起動していないものを確認できる
 */
$ docker-compose ps -a

/* 
 コンテナ削除
 ホストマシン内のコンテナを削除
 */
$ docker rm　コンテナ名
// もしくは
$ docker rm　コンテナID

/* 
 イメージ削除
 ホストマシン内のイメージを削除
 ※ コンテナが存在していると削除できないので注意してください
 */
$ docker rmi イメージ名:タグ名
// もしくは
$ docker rmi　イメージID
```

### <code>-it</code>オプションについて
```
-i
```
→"Keep STDIN open even if not attached"<br/>
→標準入力を開き続ける。

```
-t
```
→"Allocate a pseudo-TTY"<br/>
→疑似ttyを割りあてる。

手元の環境で標準入力を可能にし、コンテナ内を操作出来るようにする。

### <code>env_file</code>について
今回は、MYSQLのデータを隠すために使用しました。
好きに設定を書き込んでください。


### <code>volumes</code>について
・「volume」とは、コンテナやイメージ外でディレクトリを格納しているもの
→複数のコンテナからマウントされる

・「マウント」とは、コンテナやイメージの外部にあるディレクトリやファイルをコンテナからアクセスできるようにする
→マウントには「3種類」ある
⒈bind：ホストにあるディレクトリやファイルの直接マウント
⒉volume：Dockerが管理しているボリュームのマウント
⒊tmpfs：tmpfsというメモリを使ったファイルマウント

https://qiita.com/wwbQzhMkhhgEmhU/items/7285f05d611831676169

## ☆解決策
既存プロジェクトをcloneしてきて、<code>php artisan</code>コマンドが叩けない時

```
$ docker exec -it コンテナ名(今回は'php_sample') bash
# composer install && composer update
```
https://qiita.com/pugiemonn/items/3d000ac0486987dd92df

## ☆プロジェクトの日本語化
Laravelのメッセージ・文言を日本語にする<br/>
https://qiita.com/ponko2/items/f2f59b43dae1561ceb50#%E6%97%A5%E6%9C%AC%E8%AA%9E%E3%81%AE%E8%A8%80%E8%AA%9E%E3%83%95%E3%82%A1%E3%82%A4%E3%83%AB%E3%82%92%E8%BF%BD%E5%8A%A0
