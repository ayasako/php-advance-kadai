<?php
 $dsn = 'mysql:dbname=php_book_app;host=localhost;charset=utf8mb4';
 $user = 'root';
// MAMPを利用しているMacユーザーの方は、''ではなく'root'を代入してください
 $password = 'root';
 
 try {
    $pdo = new PDO($dsn, $user, $password);

     // orderパラメータの値が存在すれば（並び替えボタンを押したとき）、その値を変数$orderに代入する
     if (isset($_GET['order'])) {
        $order = $_GET['order'];
    } else {
        $order = NULL;
    }

     // orderパラメータの値によってSQL文を変更する    
     if ($order === 'desc') {
        $sql_select = 'SELECT * FROM books ORDER BY updated_at DESC';
    } else {
        $sql_select = 'SELECT * FROM books ORDER BY updated_at ASC';
    }

    // SQL文を実行する
    $stmt_select = $pdo->query($sql_select);

    // SQL文の実行結果を配列で取得する
    $products = $stmt_select->fetchAll(PDO::FETCH_ASSOC);

   
} catch (PDOException $e) {
    exit($e->getMessage());
}
?>
 
 <!DOCTYPE html>
 <html lang="ja">

 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>書籍一覧</title>
     <link rel="stylesheet" href="css/style.css">
 
     <!-- Google Fontsの読み込み -->
     <link rel="preconnect" href="https://fonts.googleapis.com">
     <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
     <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP&display=swap" rel="stylesheet">
 </head>
 
 <body>
     <header>
         <nav>
             <a href="index.php">書籍管理アプリ</a>
         </nav>
     </header>
     <main>
         <article class="books">
             <h1>書籍一覧</h1>
             <div class="books-ui">
                <div>
                    <a href="read.php?order=desc&keyword=<?= $keyword ?>">
                        <img src="images/desc.png" alt="降順に並び替え" class="sort-img">
                    </a>
                    <a href="read.php?order=asc&keyword=<?= $keyword ?>">
                        <img src="images/asc.png" alt="昇順に並び替え" class="sort-img">
                    </a>
                    <form action="read.php" method="get" class="search-form">
                        <input type="hidden" name="order" value="<?= $order ?>">
                        <input type="text" class="search-box" placeholder="商品名で検索" name="keyword" value="<?= $keyword ?>">
                    </form>
                </div>
                 <a href="#" class="btn">書籍登録</a>
             </div>
             <table class="books-table">
                <tr>
                    <th>書籍コード</th>
                    <th>書籍名</th>
                    <th>値段</th>
                    <th>在庫数</th>
                    <th>ジャンルコード</th>
                </tr>
                <?php
                foreach ($books as $book) {
                    $table_row = "
                    <tr>
                    <td>{$book['book_code']}</td>
                    <td>{$book['book_name']}</td>
                    <td>{$book['price']}</td>
                    <td>{$book['stock_quantity']}</td>
                    <td>{$book['genre_code']}</td>
                    </tr>
                ";
                    echo $table_row;
                }
                ?>
             </table>
         </article>
     </main>
     <footer>
         <p class="copyright">&copy; 書籍管理アプリ All rights reserved.</p>
     </footer>
 </body>
 
 </html>
