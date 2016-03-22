<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Promocion;

/**
 * PromocionSearch represents the model behind the search form about `common\models\Promocion`.
 */
class PromocionSearch extends Promocion
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idpromocion', 'lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado', 'domingo', 'estado_idestado'], 'integer'],
            [['nombre', 'hora_inicio', 'hora_fin'], 'safe'],
            [['porcentaje_descuento'], 'number'],
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
    public function search($params)
    {
        $query = Promocion::find();

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
            'idpromocion' => $this->idpromocion,
            'porcentaje_descuento' => $this->porcentaje_descuento,
            'hora_inicio' => $this->hora_inicio,
            'hora_fin' => $this->hora_fin,
            'lunes' => $this->lunes,
            'martes' => $this->martes,
            'miercoles' => $this->miercoles,
            'jueves' => $this->jueves,
            'viernes' => $this->viernes,
            'sabado' => $this->sabado,
            'domingo' => $this->domingo,
            'estado_idestado' => $this->estado_idestado,
        ]);

        $query->andFilterWhere(['like', 'nombre', $this->nombre]);

        return $dataProvider;
    }
}
