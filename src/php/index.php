<!--Arquivo HTML está junto com o PHP-->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CRUD</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!--Arquivo CSS importado-->
    <link rel="stylesheet" href="./css/index.css"/>

</head>

<body>
    <div class="container">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-6">
                        <h2>Gestão de Clientes</h2>
                    </div>
                    <div class="col-sm-6"> <!--modal adicionar e deletar para ficar mais prático-->
                        <a href="#addClientModal" class="btn btn-success" data-toggle="modal"><i
                           class="material-icons">&#xE147;</i> <span>Adicionar Cliente</span></a>
                        <a href="#deleteClientModal" class="btn btn-danger" data-toggle="modal"><i
                           class="material-icons">&#xE15C;</i> <span>Deletar</span></a>
                    </div>
                </div>
            </div>

            <?php
            //inclui o arquivo de conexão com o banco
            require_once "config.php";
                    
            //tenta selecionar a execução da consulta
            $sql = "SELECT * FROM clients";
            if($result = mysqli_query($link, $sql)){ //se a conexão foi um sucesso
                if(mysqli_num_rows($result) > 0){ //caso não esteja vazio
                    echo '<table class="table table-striped table-hover">';
                    echo "<thead>";
                        echo "<tr>";
                            echo "<th>"; //responsável pelos checkboxs
                                echo '<span class="custom-checkbox">'
                                    echo '<input type="checkbox" id="selectAll">'
                                    echo '<label for="selectAll"></label>'
                                echo "</span>"
                            echo "</th>";
                            echo "<th>#</th>"; //id
                            echo "<th>Nome</th>";
                            echo "<th>Email</th>";
                            echo "<th>Endereço</th>";
                            echo "<th>Contato</th>";
                            echo "<th>Ações</th>";
                        echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";

                    while($row = mysqli_fetch_array($result)){ //guarda os dados em índices numéricos na matriz do resultado
                        echo "<tr>";
                            echo "<td>";
                                echo <span class="custom-checkbox">
                                    echo <input type="checkbox" id="checkbox1" name="options[]" value="1">
                                    echo <label for="checkbox1"></label>
                                echo </span>
                            echo "</td>";
                            echo "<td>" . $row['id'] . "</td>";
                            echo "<td>" . $row['name'] . "</td>";
                            echo "<td>" . $row['email'] . "</td>";
                            echo "<td>" . $row['address'] . "</td>";
                            echo "<td>" . $row['contact'] . "</td>";
                            echo "<td>"; //modal editar e deletar para ficar mais prático
                                echo '<a href="#editClientModal" class="edit" data-toggle="modal"><i class="material-icons"
                                        data-toggle="tooltip" title="Editar">&#xE254;</i></a>';
                                echo '<a href="#deleteClientModal" class="delete" data-toggle="modal"><i class="material-icons"
                                        data-toggle="tooltip" title="Deletar">&#xE872;</i></a>';
                            echo "</td>";
                        echo "</tr>";
                    }
                        echo "</tbody>";
                    echo "</table>";

                    mysqli_free_result($result); //libera memória
                } else{ //caso esteja vazio
                    echo '<div class="alert alert-danger"><em>Nenhum registro foi encontrado.</em></div>';
                }
            } else{ //conexão sem sucesso
                echo "Algo deu errado. Por favor, tente novamente mais tarde.";
            }

            mysqli_close($link); //interrompe a conexão com o banco
            ?>
            
            <!--paginação-->
            <div class="clearfix">
                <div class="hint-text">Página <b>1</b> de <b>57</b></div>
                <ul class="pagination">
                    <li class="page-item disabled"><a href="#"><<</a></li>
                    <li class="page-item active"><a href="#" class="page-link">1</a></li>
                    <li class="page-item"><a href="#" class="page-link">2</a></li>
                    <li class="page-item"><a href="#" class="page-link">3</a></li>
                    <li class="page-item"><a href="#" class="page-link">4</a></li>
                    <li class="page-item"><a href="#" class="page-link">5</a></li>
                    <li class="page-item"><a href="#" class="page-link">>></a></li>
                </ul>
            </div>
        </div>
    </div>
    
    <!-- Add Modal -->
    <?php
    //inclui o arquivo de conexão com o banco
    require_once "config.php";
    
    //definição das variáveis e incialização das mesmas com vazio
    $name = $email = $address = $contact = "";
    $name_err = $email_err = $address_err = $contact_err = "";
    
    //processa os dados enviados
    if($_SERVER["REQUEST_METHOD"] == "POST"){

        //validação do nome
        $input_name = trim($_POST["name"]);
        if(empty($input_name)){
            $name_err = "Por favor, preencha com o nome.";
        } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
            $name_err = "Por favor, preencha com um nome válido.";
        } else{
            $name = $input_name;
        }

        //validação do email
        $input_email = trim($_POST["email"]);
        if(empty($input_email)){
            $email_err = "Por favor, preencha com o email.";
        } elseif(!filter_var($input_email, FILTER_VALIDATE_EMAIL)){
            $email_err = "Por favor, preencha com um email válido.";
        } else{
            $email = $input_email;
        }
        
        //validação do endereço
        $input_address = trim($_POST["address"]);
        if(empty($input_address)){
            $address_err = "Por favor, preencha com o endereço.";     
        } else{
            $address = $input_address;
        }
        
        //validação do contato
        $input_contact = trim($_POST["contact"]);
        if(empty($input_contact)){
            $contact_err = "Por favor, preencha com o contato.";     
        } elseif(!ctype_digit($input_contact)){
            $contact_err = "Por favor, preencha com dígitos.";
        } else{
            $contact = $input_contact;
        }
        
        //verifica os erros de entrada antes de inserir no banco de dados
        if(empty($name_err) && empty($email_err) && empty($address_err) && empty($contact_err)){
            //prepara uma declaração de inserção
            $sql = "INSERT INTO clients (name, email, address, contact) VALUES (?, ?, ?, ?)";
            
            if($stmt = mysqli_prepare($link, $sql)){
                //variáveis passadas como parametros
                mysqli_stmt_bind_param($stmt, "sss", $param_name, $param_email, $param_address, $param_contact);
                
                $param_name = $name;
                $param_email = $email;
                $param_address = $address;
                $param_salary = $contact;
                
                //tentativa de execução
                if(mysqli_stmt_execute($stmt)){ //caso a execução seja sucesso
                    header("location: index.php");
                    exit();
                } else{ //caso contrário...
                    echo "Algo deu errado. Por favor, tente novamente mais tarde.";
                }
            }
            
            mysqli_stmt_close($stmt); //interrompe a declaração
        }
        
        mysqli_close($link); //interrompe a conexão com o banco
    }
    ?>

    <!-- Add Modal com HTML -->
    <div id="addClientModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form>
                    <div class="modal-header">
                        <h4 class="modal-title">Adicionar Cliente</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nome</label>
                            <input type="text" name="name" class="form-control" value="<?php echo $name; ?>" required> <!-- required: faz com que seja obrigatória o preenchimento do campo -->
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" value="<?php echo $email; ?>" required> <!-- required: faz com que seja obrigatória o preenchimento do campo -->
                        </div>
                        <div class="form-group">
                            <label>Endereço</label>
                            <textarea name="address" class="form-control" required><?php echo $address; ?></textarea> <!-- required: faz com que seja obrigatória o preenchimento do campo -->
                        </div>
                        <div class="form-group">
                            <label>Contato</label>
                            <input type="text" name="contact" class="form-control" value="<?php echo $contact; ?>" required> <!-- required: faz com que seja obrigatória o preenchimento do campo -->
                        </div>
                    </div>
                    <div class="modal-footer"> <!-- responsável pelos botões de cancelar e adicionar -->
                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancelar">
                        <input type="submit" class="btn btn-success" value="Adicionar">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <?php
    //inclui o arquivo de conexão com o banco
    require_once "config.php";
    
    //definição das variáveis e incialização das mesmas com vazio
    $name = $email = $address = $contact = "";
    $name_err = $email_err = $address_err = $contact_err = "";
    
    //processa os dados enviados
    if(isset($_POST["id"]) && !empty($_POST["id"])){
        //obtem o valor de entrada
        $id = $_POST["id"];

        //validação do nome
        $input_name = trim($_POST["name"]);
        if(empty($input_name)){
            $name_err = "Por favor, preencha com o nome.";
        } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
            $name_err = "Por favor, preencha com um nome válido.";
        } else{
            $name = $input_name;
        }

        //validação do email
        $input_email = trim($_POST["email"]);
        if(empty($input_email)){
            $email_err = "Por favor, preencha com o email.";
        } elseif(!filter_var($input_email, FILTER_VALIDATE_EMAIL)){
            $email_err = "Por favor, preencha com um email válido.";
        } else{
            $email = $input_email;
        }
        
        //validação do endereço
        $input_address = trim($_POST["address"]);
        if(empty($input_address)){
            $address_err = "Por favor, preencha com o endereço.";     
        } else{
            $address = $input_address;
        }
        
        //validação do contato
        $input_contact = trim($_POST["contact"]);
        if(empty($input_contact)){
            $contact_err = "Por favor, preencha com o contato.";     
        } elseif(!ctype_digit($input_contact)){
            $contact_err = "Por favor, preencha com dígitos.";
        } else{
            $contact = $input_contact;
        }
        
        //verifica os erros de entrada antes de inserir no banco de dados
        if(empty($name_err) && empty($email_err) && empty($address_err) && empty($contact_err)){
            //prepara uma declaração de inserção
            $sql = "UPDATE clients SET name=?, email=?, address=?, contact=? WHERE id=?";
            
            if($stmt = mysqli_prepare($link, $sql)){
                //variáveis passadas como parametros
                mysqli_stmt_bind_param($stmt, "sssi", $param_name, $param_email, $param_address, $param_contact, $param_id);
                
                $param_name = $name;
                $param_email = $email;
                $param_address = $address;
                $param_salary = $contact;
                $param_id = $id;
                
                //tentativa de execução
                if(mysqli_stmt_execute($stmt)){ //caso a execução seja sucesso
                    header("location: index.php");
                    exit();
                } else{ //caso contrário...
                    echo "Algo deu errado. Por favor, tente novamente mais tarde.";
                }
            }
            
            
            mysqli_stmt_close($stmt); //interrompe a declaração
        }

        mysqli_close($link); //interrompe a conexão com o banco

    } else{ //caso não exista a variável id
        if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){ //verifica novamente
            //obtem o parâmetro da url
            $id =  trim($_GET["id"]);
            
            //prepara uma declaração de seleção
            $sql = "SELECT * FROM clients WHERE id = ?";
            if($stmt = mysqli_prepare($link, $sql)){
                //variáveis passadas como parâmetros
                mysqli_stmt_bind_param($stmt, "i", $param_id);
                
                $param_id = $id;
                
                //tentativa de execução
                if(mysqli_stmt_execute($stmt)){
                    $result = mysqli_stmt_get_result($stmt);
        
                    if(mysqli_num_rows($result) == 1){
                        /* busca a linha de resultado como uma matriz associativa,
                        como o conjunto de resultados contém apenas uma linha, não precisou usar while */
                        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                        
                        //recupera valor de campo individual
                        $name = $row["name"];
                        $email = $row["email"];
                        $address = $row["address"];
                        $contact = $row["contact"];
                    }
                    
                } else{
                    echo "Algo deu errado. Por favor, tente novamente mais tarde.";
                }
            }
            
            mysqli_stmt_close($stmt); //interrompe a declaração
            
            mysqli_close($link); //interrompe a conexão com o banco
        }
    }
    ?>

    <!-- Edit Modal com HTML -->
    <div id="editClientModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form>
                    <div class="modal-header">
                        <h4 class="modal-title">Editar Cadastro</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nome</label>
                            <input type="text" name="name" class="form-control" value="<?php echo $name; ?>" required> <!-- required: faz com que seja obrigatória o preenchimento do campo -->
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" value="<?php echo $email; ?>" required> <!-- required: faz com que seja obrigatória o preenchimento do campo -->
                        </div>
                        <div class="form-group">
                            <label>Endereço</label>
                            <textarea name="address" class="form-control" required><?php echo $address; ?></textarea> <!-- required: faz com que seja obrigatória o preenchimento do campo -->
                        </div>
                        <div class="form-group">
                            <label>Contato</label>
                            <input type="text" name="contact" class="form-control" value="<?php echo $contact; ?>" required> <!-- required: faz com que seja obrigatória o preenchimento do campo -->
                        </div>
                    </div>
                    <div class="modal-footer"> <!-- responsável pelos botões de cancelar e salvar -->
                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancelar">
                        <input type="submit" class="btn btn-info" value="Salvar">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <?php
    if(isset($_POST["id"]) && !empty($_POST["id"])){
        //inclui o arquivo de conexão com o banco
        require_once "config.php";
        
        //prepara a declaração de deleção
        $sql = "DELETE FROM clients WHERE id = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            //variáveis passadas como parâmetros
            mysqli_stmt_bind_param($stmt, "i", $param_id);

            $param_id = trim($_POST["id"]);
            
            //tentativa de execução
            if(mysqli_stmt_execute($stmt)){ //caso a exclusão seja um sucesso
                header("location: index.php");
                exit();
            } else{ //caso contrário...
                echo "Algo deu errado. Por favor, tente novamente mais tarde.";
            }
        }
        
        mysqli_stmt_close($stmt); //interrompe a declaração
        
        mysqli_close($link); //interrompe a conexão com o banco
    }
    ?>

    <!-- Delete Modal com HTML -->
    <div id="deleteClientModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form>
                    <div class="modal-header">
                        <h4 class="modal-title">Deletar Cadastro</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <p>Você tem certeza que deseja deletar este cadastro?</p>
                        <p class="text-warning"><small>Esta ação não pode ser desfeita.</small></p>
                    </div>
                    <div class="modal-footer">
                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancelar">
                        <input type="submit" class="btn btn-danger" value="Deletar">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- importa o arquivo JavaScript -->
    <script src="./js/index.js"> </script> 
    
    </body>

</html>