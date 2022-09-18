<?php
require($_SERVER['DOCUMENT_ROOT'] . '/config.php');
$page_content = "";

$html_form = <<<HTML
    <div class="container">
        <div class="row justify-content-center">

    <form class="col-sm-10 col-md-8 col-lg-6 " action="index.php" method="POST" enctype="multipart/form-data" action="">
    <h1>Cadastro de Relógios</h1>

    <div class="form-floating mb-3">
             <input type="text" name="name" id="name" class="form-control" placeholder=" " autofocus>
                <label for="txtEmail">Nome</label>
     </div>
     <div class="form-floating mb-3 ">
             <input type="text" name="preco" class="form-control" placeholder="" onkeypress="$(this).mask('#.##0,00', {reverse: true});">
                <label for="txtEmail">Preço em R$</label>
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
         <input type="file" name="arquivo">
        </p>
        <button class="btn btn-dark" type="submit">Cadastrar</button>
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
            $price = str_replace('.', '', $_POST['preco']);
            $priceFormater = str_replace(',', '.', $price);
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
                $sql = "INSERT INTO relogios (name,preco,qtd_estoque,img,descr) VALUES('$name','$priceFormater','$estoque','$path','$desc')";
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

echo <<<HTML
$page_content;


<script src="script.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

HTML;


require($_SERVER['DOCUMENT_ROOT'] . '/footer.php');
