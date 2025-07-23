<?php
/**
 * Obra Model
 */

require_once 'BaseModel.php';

class Obra extends BaseModel {
    protected $table = 'obras';
    
    /**
     * Get obras with user information
     */
    public function getAllWithUser() {
        $sql = "SELECT o.*, u.nombre as usuario_nombre 
                FROM {$this->table} o 
                LEFT JOIN usuarios u ON o.usuario_id = u.id 
                ORDER BY o.fecha_creacion DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }
    
    /**
     * Get obra with summary statistics
     */
    public function getWithStats($id) {
        $sql = "SELECT o.*, 
                       COUNT(c.id) as total_conceptos,
                       SUM(c.importe) as presupuesto_calculado,
                       SUM(c.costo_real) as costo_real_total,
                       AVG(c.avance_fisico) as avance_promedio,
                       u.nombre as usuario_nombre
                FROM {$this->table} o 
                LEFT JOIN conceptos c ON o.id = c.obra_id
                LEFT JOIN usuarios u ON o.usuario_id = u.id
                WHERE o.id = ?
                GROUP BY o.id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    /**
     * Get obras by user
     */
    public function getByUser($user_id) {
        return $this->where(['usuario_id' => $user_id]);
    }
    
    /**
     * Get obras dashboard data
     */
    public function getDashboardData() {
        $sql = "SELECT 
                    COUNT(*) as total_obras,
                    SUM(CASE WHEN estado = 'en_proceso' THEN 1 ELSE 0 END) as obras_activas,
                    SUM(CASE WHEN estado = 'terminada' THEN 1 ELSE 0 END) as obras_terminadas,
                    SUM(presupuesto_total) as presupuesto_total,
                    AVG(avance_fisico) as avance_promedio
                FROM {$this->table}";
        
        $stmt = $this->db->query($sql);
        return $stmt->fetch();
    }
    
    /**
     * Update progress
     */
    public function updateProgress($id) {
        $sql = "UPDATE {$this->table} SET 
                    avance_fisico = (
                        SELECT AVG(c.avance_fisico) 
                        FROM conceptos c 
                        WHERE c.obra_id = ?
                    ),
                    avance_financiero = (
                        SELECT CASE 
                            WHEN SUM(c.importe) > 0 
                            THEN (SUM(c.costo_real) / SUM(c.importe)) * 100 
                            ELSE 0 
                        END
                        FROM conceptos c 
                        WHERE c.obra_id = ?
                    )
                WHERE id = ?";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id, $id, $id]);
    }
}