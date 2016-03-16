<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\PromocionProducto;

/**
 * PromocionProductoSearch represents the model behind the search form about `common\models\PromocionProducto`.
 */
class PromocionProductoSearch extends PromocionProducto
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idpromocion_producto', 'promocion_idpromocion', 'producto_idproducto'], 'integer'],
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
    public function search($params, $idpromocion)
    {
        $query = PromocionProducto::find();
        $query->joinWith(['producto']);
        
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
            'idpromocion_producto' => $this->idpromocion_producto,
            'promocion_idpromocion' => $idpromocion,
            'producto_idproducto' => $this->producto_idproducto,
        ]);

        return $dataProvider;
    }
}
