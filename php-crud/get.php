<?php
include 'db.php';

$db = new DB();
if(isset($_GET['action'])){
    if(isset($_GET['tableName'])){
        $tblName=$_GET['tableName'];
        switch($_GET['action']){
            case 'get':
                $condition=$where=[];
                //select
                if(isset($_GET['select'])){
                    $columns=$db->getColumns($tblName);
                    $key = array_search($_GET['select'], $columns); //check if this column is present in table columns
                    if (false !== $key){
                        $condition['select']=$_GET['select'];
                    }

                    //distinct - accepts 1 or true
                    if (isset($_GET['distinct']) and ($_GET['distinct']=='true' or $_GET['distinct']==1)) {
                        $condition['select']= 'distinct('.$_GET['select'].')';
                    }
                }


                //where
                if(isset($_GET['where']) and isset($_GET['whereval'])){
                    if(count($_GET['where'])==count($_GET['whereval'])){
                        $columns=$db->getColumns($tblName);
                        for($i=0;$i<count($_GET['where']);$i++){
                            $key = array_search($_GET['where'][$i], $columns); //check if this column is present in table columns
                            if (false !== $key){
                                $where[$_GET['where'][$i]]=$_GET['whereval'][$i];
                            }
                        }
                    }
                    $condition['where']=$where;
                }

                //group_by - accepts only columns present in table
                if(isset($_GET['groupby'])){
                    $columns=$db->getColumns($tblName);
                    $key = array_search($_GET['groupby'], $columns); //check if this column is present in table columns
                    if (false !== $key){
                        $condition['group_by']=$_GET['groupby'];
                    }
                }

                //order_by - accepts only columns present in table
                $condition['order_by']='id';
                if(isset($_GET['orderby'])){
                    $columns=$db->getColumns($tblName);
                    $key = array_search($_GET['orderby'], $columns); //check if this column is present in table columns
                    if (false !== $key){
                        $condition['order_by']=$_GET['orderby'];
                    }
                }

                //sortby_by accepts ASC|DESC
                if(isset($_GET['sortby'])){
                    if ($_GET['sortby']=='ASC' or $_GET['sortby']=='DESC') {
                        $condition['order_by'].=' '.$_GET['sortby'];
                    }
                }   else {
                    $condition['order_by'].=' ASC';
                }

                //limit - accepts only numbers
                if(isset($_GET['limit'])){
                    $condition['limit']=$_GET['limit'];
                }

                //return_type count|single\all
                if(isset($_GET['returntype'])){
                    switch ($_GET['returntype']) {
                        case 'single': case 'count': case 'all':
                            $condition['return_type']=$_GET['returntype'];
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
                if(isset($_GET['column']) and isset($_GET['columnval'])){
                    if(count($_GET['column'])==count($_GET['columnval'])){
                        $columns=$db->getColumns($tblName);
                        for($i=0;$i<count($_GET['column']);$i++){
                            $key = array_search($_GET['column'][$i], $columns); //check if this column is present in table columns
                            if (false !== $key){
                                $data[$_GET['column'][$i]]=$_GET['columnval'][$i];
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
                if(isset($_GET['column']) and isset($_GET['columnval'])){
                    if(count($_GET['column'])==count($_GET['columnval'])){
                        $columns=$db->getColumns($tblName);
                        for($i=0;$i<count($_GET['column']);$i++){
                            $key = array_search($_GET['column'][$i], $columns); //check if this column is present in table columns
                            if (false !== $key){
                                $data[$_GET['column'][$i]]=$_GET['columnval'][$i];
                            }
                        }
                    }
                }
                //where
                if(isset($_GET['where']) and isset($_GET['whereval'])){
                    if(count($_GET['where'])==count($_GET['whereval'])){
                        $columns=$db->getColumns($tblName);
                        for($i=0;$i<count($_GET['where']);$i++){
                            $key = array_search($_GET['where'][$i], $columns); //check if this column is present in table columns
                            if (false !== $key){
                                $where[$_GET['where'][$i]]=$_GET['whereval'][$i];
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
                if(isset($_GET['where']) and isset($_GET['whereval'])){
                    if(count($_GET['where'])==count($_GET['whereval'])){
                        $columns=$db->getColumns($tblName);
                        for($i=0;$i<count($_GET['where']);$i++){
                            $key = array_search($_GET['where'][$i], $columns); //check if this column is present in table columns
                            if (false !== $key){
                                $where[$_GET['where'][$i]]=$_GET['whereval'][$i];
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
