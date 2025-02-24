<h1>お問い合わせフォーム</h1>

<h2>環境構築</h2>

<p>Dockerビルド</p>
<ol>
  <li>git clone https://github.com/Takumi8888/flea-market-application.git</li>
  <li>cd flea-market-application</li>
  <li>git remote set-url origin git@github.com:Takumi8888/flea-market-application.git</li>
  <li>docker-compose up -d --build</li>
  <li>sudo chmod -R 777 src/*</li>
</ol>
<p>＊ MySQLは、OSによって起動しない場合があるのでそれぞれのPCに合わせて docker-compose.yml ファイルを編集してください。</p>

<p>Laravel環境構築</p>
<ol>
  <li>code .</li>
  <li>docker-compose exec php bash</li>
  <li>cp .env.example .env</li>
  <li>chmod 777 .env</li>
  <li>.envファイルの環境変数を変更（docker-compose.yml参照）</li>
  <li>.envに下記アクセスキーを入力する</li>
  <p>STRIPE_PUBLIC_KEY="pk_test_51QvfMfIOgfDWvo2XL1n04iTIt8vSg2sIV6MiKlsOURbY6JE6IVsPiBTdNUXhblaknK0gXGo86dJVHBDFgfORhZF100M5fAEaCA"</p>
  <p>STRIPE_SECRET_KEY="sk_test_51QvfMfIOgfDWvo2XsqQ5fAPh9VIfY6FCj5HEbUPsta1ZiGAGMHp0elBYlFGEDOocgvQnSbEKbmLQxGMYS9OdDC1000kiKf7J44"</p>
  <li>src/public/js/item/stripe.jsに下記アクセスキーを入力する</li>
  <p>STRIPE_PUBLIC_KEY="pk_test_51QvfMfIOgfDWvo2XL1n04iTIt8vSg2sIV6MiKlsOURbY6JE6IVsPiBTdNUXhblaknK0gXGo86dJVHBDFgfORhZF100M5fAEaCA"</p>
  <li>composer update</li>
  <li>php artisan key:generate</li>
  <li>php artisan migrate --seed</li>
  <li>php artisan storage:link</li>
</ol>

<h2>使用技術</h2>
<ul>
  <li>PHP 8.2.11</li>
  <li>Laravel 10.48.25</li>
  <li>jquery 3.7.1.min.js</li>
  <li>MySQL 8.0.26</li>
  <li>nginx 1.21.1</li>
  <li>stripe/stripe-php v16.5.1</li>
</ul>

<h2>URL</h2>
<ul>
  <li>開発環境：<a href="">http://localhost/</a></li>
  <li>phpMyAdmin：<a href="">http://localhost:8080/</a></li>
</ul>

<h2>ER図</h2>
<img width="100%" alt="ER" src="https://github.com/user-attachments/assets/dd25ac25-a0aa-4094-8f1e-e73ad71a079c" />


<h2>連絡事項</h2>
<h3>デザインにおいて</h3>
<ul>
  <li>レスポンシブデザインについて</li>
  <p>画面設計より「PC (1400-1540px) で崩れない、タブレット (768-850px) で崩れない」とあります。
  <br/>そのため、差分が分かるよう指定幅以外ではあえてデザインを崩しています。</p>

  <li>プロフィール編集画面について</li>
  <p>プロフィール編集後、ユーザーが判断しやすいようにメッセージ表示をしています。</p>

  <li>出品商品編集画面について</li>
  <p>商品出品後、ユーザーが出品内容の変更ができるように編集画面を設けています。</p>
</ul>

<h3>運営側に確認済みの項目</h3>
<ul>
  <li>ブランド名について</li>
  <p>質問：機能要件にブランド名の指定がないが必要か？
  <br/>回答：ブランド名の機能を実装してください。
  <br/>質問：商品一覧データにブランド名の指定がない？
  <br/>回答：ダミーデータにはブランド名を入れておくでOKとします。</p>

  <li>バリデーションについて</li>
  <p>質問：バリデーションの指示が中途半端
  <br/>回答：ご自身で考えていただく項目となっております。
  <br/>対応：ルールの不足個所が散見されましたので、こちらでルールを追加しました。</p>
</ul>

<h3>運営側より明確な返答がない項目
<br/>（その後問い合わせしても返答がないまま、提出期日を迎えた）</h3>
<ul>
  <li>会員登録後の遷移画面について</li>
  <p>質問：機能要件には会員登録後、プロフィール設定画面に遷移するとあるが、
  <br/>　　　テストケースには「会員情報が登録され、ログイン画面」に遷移されるとある。
  <br/>回答：会員登録画面にて「ログインはこちら」ボタンをクリックするとログイン画面に
  <br/>　　　遷移できるという動線になります。
  <br/>未解決の理由：質問の内容を理解されていない回答であり、本質問とはずれています。</p>

  <li>未認証時のコメント操作について</li>
  <p>質問：機能要件を確認すると、認証が必要なアクションを行った場合、ログイン画面に
  <br/>　　　遷移するとある。先の条件を踏まえ「コメント送信」を考えた場合、ユーザー
  <br/>　　　がログインしなければ「コメント送信」が実行できないことを意味している。
  <br/>　　　そのため、テストケースにある「コメントを送信できないことを確かめる」は誤り
  <br/>　　　であり、「ログイン画面に遷移する」が正しいフローである。
  <br/>回答：ログイン前のユーザーがコメントを送信できないことを確認するテスト
  <br/>　　　となっておりますので、ログイン画面遷移のテストは行っておりません。
  <br/>未解決の理由：機能要件を満たした回答ではないため。</p>

  <li>コメントのテストケースのバリデーションについて</li>
  <p>質問：コメントのテストケースにて、「256文字以上のコメントを入力する」と
  <br/>　　　誤った表現がある。
  <br/>回答：該当箇所を修正しました。
  <br/>未解決の理由：何をどのように修正したのか、その内容を教えてもらえない。</p>

  <li>プロフィール編集画面について</li>
  <p>質問：figmaには建物名があるが、スプレットシートには建物名がない。
  <br/>回答：該当箇所を修正しました。
  <br/>未解決の理由：何をどのように修正したのか、その内容を教えてもらえない。</p>

</ul># flea-market-application# flea-market-application
# flea-market-application
# flea-market-application
