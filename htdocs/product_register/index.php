<?php
require($_SERVER['DOCUMENT_ROOT'] . '/config.php');
$page_content = "";

$html_form = <<<HTML
    <div class="container">
        <div class="row justify-content-center">

    <form class="col-sm-10 col-md-8 col-lg-6 " method="POST" enctype="multipart/form-data" action="">
    <h1>Cadastro de Relógios</h1>

    <div class="form-floating mb-3">
             <input type="text" name="name" id="name" class="form-control" placeholder=" " autofocus>
                <label for="txtEmail">Nome</label>
     </div>
     <div class="form-floating mb-3 ">
             <input type="text" name="preco" id="preco" class="form-control" placeholder=" " autofocus>
                <label for="txtEmail">Preco</label>
     </div>
     <div class="form-floating mb-3">
             <input type="number" name="qtd_estoque" id="qtd_estoque" class="form-control" placeholder=" " autofocus>
                <label for="txtEmail">Quantidade em estoque</label>
     </div>
      <div class="form-floating">
    <textarea name="desc" class="form-control" placeholder="Descreva o produto" id="text-area" style="height: 100px"></textarea>
    <label for="floatingTextarea2">Descrição</label>
    </div>

        <p><label for="">Selecione o Arquivo</label>
            <input type="file" name="arquivo" id="" >
        </p>
        <button name="upload" type="submit">Enviar Arquivo</button>
        </form>
 HTML;



if (!empty($_FILES['arquivo'])) :
    $file = $_FILES['arquivo'];

    if ($file['error']) :
        $page_content .= <<<HTML
        <div class="alert alert-danger text-center" role="alert">
        Imagem não enviada, tente novamente.
        </div>
        {$html_form}
HTML;

    elseif ($file['size'] > 2097152) :
        $page_content .= <<<HTML
<div class="alert alert-danger text-center" role="alert">
Envie imagens de até 2MB!
</div>
{$html_form}
HTML;

    else :

        $folder = "../arquivos/";
        $fileName = $file['name'];
        $newFileName = uniqid();
        $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        if ($extension != 'jpg' && $extension != 'png') :
            $page_content .= <<<HTML
    <div class="alert alert-danger text-center" role="alert">
    Formato de arquivo não suportado!
    </div>
            {$html_form}
HTML;

        else :

            $path = $folder . $newFileName . "." . $extension;

            $name = $_POST['name'];
            $price = $_POST['preco'];
            $estoque = $_POST['qtd_estoque'];
            $desc = $_POST['desc'];

            if (empty($name) or empty($price) or empty($estoque) or empty($desc)) :
                $page_content .= <<<HTML
        <div class="alert alert-danger text-center" role="alert">
       Preencha todos os Campos
        </div>
            {$html_form}        
    HTML;

            else :
                $move = move_uploaded_file($file["tmp_name"], $path);
                $sql = "INSERT INTO relogios (name,preco,qtd_estoque,img,descr) VALUES('$name','$price','$estoque','$path',$desc)";
                $conn->query($sql);


                $page_content .= <<<HTML
        <div class="alert alert-success text-center" role="alert">
        Produto Cadastrado com sucesso
        </div>
            {$html_form}        
HTML;

            endif;

        endif;

    endif;

else :
    $page_content .= $html_form;

endif;




require($_SERVER['DOCUMENT_ROOT'] . '/header.php');

echo $page_content;

require($_SERVER['DOCUMENT_ROOT'] . '/footer.php');
