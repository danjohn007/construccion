<?php
/**
 * Concepto Model
 */

require_once 'BaseModel.php';

class Concepto extends BaseModel {
    protected $table = 'conceptos';
    
    /**
     * Get conceptos by obra
     */
    public function getByObra($obra_id) {
        return $this->where(['obra_id' => $obra_id]);
    }
    
    /**
     * Get concepto with related data
     */
    public function getWithRelated($id) {
        $sql = "SELECT c.*, 
                       o.nombre as obra_nombre,
                       COUNT(pu.id) as total_precios_unitarios,
                       COUNT(v.id) as total_volumenes
                FROM {$this->table} c 
                LEFT JOIN obras o ON c.obra_id = o.id
                LEFT JOIN precios_unitarios pu ON c.id = pu.concepto_id
                LEFT JOIN volumenes v ON c.id = v.concepto_id
                WHERE c.id = ?
                GROUP BY c.id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    /**
     * Get conceptos with progress
     */
    public function getWithProgress($obra_id) {
        $sql = "SELECT c.*,
                       COALESCE(SUM(av.cantidad_ejecutada), 0) as cantidad_ejecutada,
                       COALESCE(SUM(av.importe_ejecutado), 0) as importe_ejecutado,
                       CASE 
                           WHEN c.cantidad > 0 
                           THEN (COALESCE(SUM(av.cantidad_ejecutada), 0) / c.cantidad) * 100 
                           ELSE 0 
                       END as porcentaje_real
                FROM {$this->table} c
                LEFT JOIN avance_obra av ON c.id = av.concepto_id
                WHERE c.obra_id = ?
                GROUP BY c.id
                ORDER BY c.clave";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$obra_id]);
        return $stmt->fetchAll();
    }
    
    /**
     * Update concepto progress
     */
    public function updateProgress($id) {
        $sql = "UPDATE {$this->table} SET 
                    avance_fisico = (
                        SELECT CASE 
                            WHEN c.cantidad > 0 
                            THEN (COALESCE(SUM(av.cantidad_ejecutada), 0) / c.cantidad) * 100 
                            ELSE 0 
                        END
                        FROM conceptos c
                        LEFT JOIN avance_obra av ON c.id = av.concepto_id
                        WHERE c.id = ?
                    )
                WHERE id = ?";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id, $id]);
    }
    
    /**
     * Get conceptos by etapa
     */
    public function getByEtapa($obra_id, $etapa) {
        return $this->where(['obra_id' => $obra_id, 'etapa' => $etapa]);
    }
    
    /**
     * Calculate precio unitario from components
     */
    public function calculatePrecioUnitario($concepto_id) {
        $sql = "SELECT SUM(importe) as total_precio 
                FROM precios_unitarios 
                WHERE concepto_id = ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$concepto_id]);
        $result = $stmt->fetch();
        
        return $result['total_precio'] ?? 0;
    }
}