<?php
include 'db.php';

$db = new DB();
if(isset($_POST['action'])){
    if(isset($_POST['tableName'])){
        $tblName=$_POST['tableName'];
        switch($_POST['action']){
            case 'get':
                $condition=$where=[];
                //select
                if(isset($_POST['select'])){
                    $columns=$db->getColumns($tblName);
                    $key = array_search($_POST['select'], $columns); //check if this column is present in table columns
                    if (false !== $key){
                        $condition['select']=$_POST['select'];
                    }

                    //distinct - accepts 1 or true
                    if (isset($_POST['distinct']) and ($_POST['distinct']==true or $_POST['distinct']==1)) {
                        $condition['select']= 'distinct('.$_POST['select'].')';
                    }
                }
                //where
                if(isset($_POST['where']) and isset($_POST['whereval'])){
                    if(count($_POST['where'])==count($_POST['whereval'])){
                        $columns=$db->getColumns($tblName);
                        for($i=0;$i<count($_POST['where']);$i++){
                            $key = array_search($_POST['where'][$i], $columns); //check if this column is present in table columns
                            if (false !== $key){
                                $where[$_POST['where'][$i]]=$_POST['whereval'][$i];
                            }
                        }
                    }
                    $condition['where']=$where;
                }

                //group_by - accepts only columns present in table
                if(isset($_POST['groupby'])){
                    $columns=$db->getColumns($tblName);
                    $key = array_search($_POST['groupby'], $columns); //check if this column is present in table columns
                    if (false !== $key){
                        $condition['group_by']=$_POST['groupby'];
                    }
                }

                //order_by - accepts only columns present in table
                $condition['order_by']='id';
                if(isset($_POST['orderby'])){
                    $columns=$db->getColumns($tblName);
                    $key = array_search($_POST['orderby'], $columns); //check if this column is present in table columns
                    if (false !== $key){
                        $condition['order_by']=$_POST['orderby'];
                    }
                }

                //sortby_by accepts ASC|DESC
                if(isset($_POST['sortby'])){
                    if ($_POST['sortby']=='ASC' or $_POST['sortby']=='DESC') {
                        $condition['order_by'].=' '.$_POST['sortby'];
                    }
                }   else {
                    $condition['order_by'].=' ASC';
                }

                //limit - accepts only numbers
                if(isset($_POST['limit'])){
                    $condition['limit']=$_GET['limit'];
                }

                //return_type count|single\all
                if(isset($_POST['returntype'])){
                    switch ($_POST['returntype']) {
                        case 'single': case 'count': case 'all':
                            $condition['return_type']=$_POST['returntype'];
                            break;

                        default:
                            break;
                    }
                }
                echo json_encode($db->getRows($tblName,$condition),JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
                break;
            case 'columns':
                echo json_encode($db->getColumns($tblName),JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
                break;
            case 'insert':
                $data=[];
                // Insert user data
                if(isset($_POST['column']) and isset($_POST['columnval'])){
                    if(count($_POST['column'])==count($_POST['columnval'])){
                        $columns=$db->getColumns($tblName);
                        for($i=0;$i<count($_POST['column']);$i++){
                            $key = array_search($_POST['column'][$i], $columns); //check if this column is present in table columns
                            if (false !== $key){
                                $data[$_POST['column'][$i]]=$_POST['columnval'][$i];
                            }
                        }
                    }
                }
                if($db->insert($tblName, $data)){
                    echo '{"msg":"success"}';
                } else {
                    $param = $db->getColumns($tblName);
                    $arr = array(
                        'msg'=>'error',
                        'table_name'=> $tblname,
                        'table_columns'=> $param
                    );
                    echo json_encode($arr,JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
                }
                break;
            case 'update':
                $data=$condition=$where=[];
                // update data
                if(isset($_POST['column']) and isset($_POST['columnval'])){
                    if(count($_POST['column'])==count($_POST['columnval'])){
                        $columns=$db->getColumns($tblName);
                        for($i=0;$i<count($_POST['column']);$i++){
                            $key = array_search($_POST['column'][$i], $columns); //check if this column is present in table columns
                            if (false !== $key){
                                $data[$_POST['column'][$i]]=$_POST['columnval'][$i];
                            }
                        }
                    }
                }
                //where
                if(isset($_POST['where']) and isset($_POST['whereval'])){
                    if(count($_POST['where'])==count($_POST['whereval'])){
                        $columns=$db->getColumns($tblName);
                        for($i=0;$i<count($_POST['where']);$i++){
                            $key = array_search($_POST['where'][$i], $columns); //check if this column is present in table columns
                            if (false !== $key){
                                $where[$_POST['where'][$i]]=$_POST['whereval'][$i];
                            }
                        }
                    }
                }

                if($db->update($tblName, $data, $where)){
                    echo '{"msg":"success"}';
                } else {
                    $param = $db->getColumns($tblName);
                    $arr = array(
                        'msg'=>'error',
                        'table_name'=> $tblname,
                        'table_columns'=> $param
                    );
                    echo json_encode($arr,JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
                }

                break;
            case 'delete':
                $where=[];

                //where
                if(isset($_POST['where']) and isset($_POST['whereval'])){
                    if(count($_POST['where'])==count($_POST['whereval'])){
                        $columns=$db->getColumns($tblName);
                        for($i=0;$i<count($_POST['where']);$i++){
                            $key = array_search($_POST['where'][$i], $columns); //check if this column is present in table columns
                            if (false !== $key){
                                $where[$_POST['where'][$i]]=$_POST['whereval'][$i];
                            }
                        }
                    }
                }

                if($db->delete($tblName, $where)){
                    echo '{"msg":"success"}';
                } else {
                    $param = $db->getColumns($tblName);
                    $arr = array(
                        'msg'=>'error',
                        'table_name'=> $tblname,
                        'table_columns'=> $param
                    );
                    echo json_encode($arr,JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
                }

                break;
            default:
                $param = [];
                array_push($param,array(
                    'param_name'=>'action',
                    'possible_values'=> ['get','insert','update','delete','columns']
                ));
                $arr = array(
                    'error'=>'Void/Wrong Action in API',
                    'params_required'=> $param
                );
                echo json_encode($arr,JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
                break;
        }
    } else {
        $param = [];
        array_push($param,array(
            'param_name'=>'tableName',
            'possible_values'=> 'string supporting char combination of [A-Z,a-z,0-9,_]',
            'existing_values'=> $db->getTables()
        ));
        $arr = array(
            'error'=>'Void Table Name in API',
            'params_required'=> $param
        );
        echo json_encode($arr,JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
} else {
    $param = [];
    array_push($param,array(
        'param_name'=>'action',
        'possible_values'=> ['get','insert','update','delete','columns','manualsql']
    ));
    array_push($param,array(
        'param_name'=>'tableName',
        'possible_values'=> 'string supporting char combination of [A-Z,a-z,0-9,_]',
        'existing_values'=> $db->getTables()
    ));
    $arr = array(
        'msg'=>'error: Void API - param required',
        'params_required'=> $param
    );
    echo json_encode($arr,JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
}
?>
