<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Detalle;

/**
 * DetalleSearch represents the model behind the search form about `common\models\Detalle`.
 */
class DetalleSearch extends Detalle
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['iddetalle', 'cantidad', 'precio', 'pedido_idpedido', 'producto_idproducto'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function searchPedidoRealizado($params, $idpedido)
    {
        $query = Detalle::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        
        $query->where(['<>', 'comanda', 0]);
        
        $query->andFilterWhere([
            'iddetalle' => $this->iddetalle,
            'cantidad' => $this->cantidad,
            'precio' => $this->precio,
            'pedido_idpedido' => $idpedido,
            'producto_idproducto' => $this->producto_idproducto,
        ]);
        
        return $dataProvider;
    }
    
    public function searchPedidoPendiente($params, $idpedido)
    {
        $query = Detalle::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'iddetalle' => $this->iddetalle,
            'cantidad' => $this->cantidad,
            'precio' => $this->precio,
            'pedido_idpedido' => $idpedido,
            'comanda' => 0,
            'producto_idproducto' => $this->producto_idproducto,
        ]);

        return $dataProvider;
    }
}
