<?php

namespace app\modules\{_MODULE_ID_}\models;

use app\modules\{_MODULE_ID_}\models\{_OBJECT_MODEL_NAME_};
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * {_OBJECT_SEARCH_MODEL_NAME_} represents the model behind the search form of `app\modules\{_MODULE_ID_}\models\{_OBJECT_MODEL_NAME_}`.
 */
class {_OBJECT_SEARCH_MODEL_NAME_} extends {_OBJECT_MODEL_NAME_}
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'created_by', 'updated_by', 'markdel_by'], 'integer'],
            [['name'], 'string'],
            [['created_at', 'updated_at', 'markdel_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
    public function search($params, $params2 = [])
    {
        $query = {_OBJECT_MODEL_NAME_}::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'markdel_at' => $this->markdel_at,
            'markdel_by' => $this->markdel_by,
            'name' => $this->name,
        ]);
        
        //$query->andFilterWhere(['like', 'number', $this->number])
        //    ->andFilterWhere(['like', 'date', $this->date]);

        return $dataProvider;
    }
}
