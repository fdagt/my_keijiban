# マイ掲示板
これは私が初めて作った電子掲示板アプリです。

## 環境
Windows 11 Home  
Apache 2.4.53  
MariaDB 10.4.24  
PHP 8.1.6  

## デプロイ
1. レポジトリをクローンする(`git clone https://github.com/fdagt/my_keijiban`)。

1. 設定を編集する。
    1. `deploy.ps1` を編集する。
        1. 1行目で定義されている `$DocumentRoot` の値をドキュメントルートのファイルパスに変更する。
        1. 2行目で定義されている `Execute-PHP` の値をPHPインタープリターのファイルパスに変更する。
    1. `htdocs/include/model/const.php` を編集する。
        1. `DB_HOST` 、 `DB_USER` 、 `DB_PASSWORD` 、 `DB_NAME` を変更する。
        1. 必要ならその他の設定を変更する。
1. デプロイスクリプトを実行する(`.\deploy.ps1`)。

## スクリーンショット
### トップページ
![トップページのスクリーンショット](/img/screen-shot-top.png)

### スレッド閲覧ページ
![スレッド閲覧ページのスクリーンショット](/img/screen-shot-thread.png)
２番目の書き込みが非表示にされている。

### 管理ページ(トップ)
![管理ページのトップのスクリーンショット](/img/screen-shot-admin-top.png)
非表示にされていたスレッドも表示されている。

### 管理ページ(書き込み管理)
![書き込み管理ページのスクリーンショット](/img/screen-shot-admin-thread.png)
書き込みを非表示にすることができる。
