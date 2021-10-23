<?php

namespace app\modules\project\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\project\models\MProject;

/**
 * MProjectSearch represents the model behind the search form of `app\modules\project\models\MProject`.
 */
class MProjectSearch extends MProject
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
    public function search($params)
    {
        $query = MProject::find();

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
