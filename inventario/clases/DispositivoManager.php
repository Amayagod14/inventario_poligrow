<?php
class DispositivoManager {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    private function ejecutarConsulta($sql, $params) {
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return true;
        } catch (PDOException $e) {
            die("Error en la consulta: " . $e->getMessage());
        }
    }

    public function agregarEmpleado($cedula, $nombre) {
        $sql = "INSERT INTO empleados (cedula, nombre) VALUES (:cedula, :nombre) 
                ON DUPLICATE KEY UPDATE nombre = :nombre";
        return $this->ejecutarConsulta($sql, [':cedula' => $cedula, ':nombre' => $nombre]);
    }

    public function agregarCelular($data) {
        $sql = "INSERT INTO celulares (cedula, serial, imei, placa_activos, marca, modelo, fecha_entrega, fecha_compra) 
                VALUES (:cedula, :serial, :imei, :placa_activos, :marca, :modelo, :fecha_entrega, :fecha_compra)";
        return $this->ejecutarConsulta($sql, $data);
    }

    public function agregarComputador($data) {
        $sql = "INSERT INTO computadores (cedula, dispositivo, marca, referencia, mac, placa_activos, serial, ram, estado_entrega, disco_duro, cuenta_email, fecha, fecha_compra) 
                VALUES (:cedula, :dispositivo, :marca, :referencia, :mac, :placa_activos, :serial, :ram, :estado_entrega, :disco_duro, :cuenta_email, :fecha_entrega, :fecha_compra)";
        return $this->ejecutarConsulta($sql, $data);
    }

    public function agregarRadio($data) {
        $sql = "INSERT INTO radios (cedula, serial, marca, placa_activos_fijos, dispositivo, referencia, estado_entrega, observaciones, fecha, fecha_compra) 
                VALUES (:cedula, :serial, :marca, :placa_activos_fijos, :dispositivo, :referencia, :estado_entrega, :observaciones, :fecha_entrega, :fecha_compra)";
        return $this->ejecutarConsulta($sql, $data);
    }

    public function agregarSimCard($data) {
        $sql = "INSERT INTO sim_cards (cedula, dispositivo, linea_celular, fecha_compra, fecha_entrega) 
                VALUES (:cedula, :dispositivo, :linea_celular, :fecha_compra, :fecha_entrega)";
        return $this->ejecutarConsulta($sql, $data);
    }
    

    public function agregarImpresora($data) {
        $sql = "INSERT INTO impresoras (cedula, marca, modelo, serial, placa_activos, estado, fecha_entrega, fecha_compra, observaciones) 
                VALUES (:cedula, :marca, :modelo, :serial, :placa_activos, :estado, :fecha_entrega, :fecha_compra, :observaciones)";
        return $this->ejecutarConsulta($sql, $data);
    }
}
?>
