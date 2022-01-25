<?php

namespace app\modules\{_MODULE_ID_}\models;

use app\modules\{_MODULE_ID_}\models\{_UPLOAD_MODEL_NAME_};
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * {_UPLOAD_SEARCH_MODEL_} represents the model behind the search form of `app\modules\{_MODULE_ID_}\models\{_UPLOAD_MODEL_NAME_}`.
 */
class {_UPLOAD_SEARCH_MODEL_} extends {_UPLOAD_MODEL_NAME_}
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'object_id', 'team_by', 'created_by', 'updated_by', 'markdel_by', 'size'], 'integer'],

            [['created_at', 'updated_at', 'markdel_at', 'filename_original', 'md5', 'ext', 'mimetype'], 'safe'],
            
            //[['type_xxx'], 'string'],
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
        $query = {_UPLOAD_MODEL_NAME_}::find();

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
            'object_id' => $this->object_id,
            'team_by' => $this->team_by,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'markdel_by' => $this->markdel_by,
            'markdel_at' => $this->markdel_at,
            'size' => $this->size,
            //'type_xxx' => $this->type_xxx,
        ]);

        $query->andFilterWhere(['like', 'filename_original', $this->filename_original])
            ->andFilterWhere(['like', 'md5', $this->md5])
            ->andFilterWhere(['like', 'ext', $this->ext])
            ->andFilterWhere(['like', 'mimetype', $this->mimetype]);

        if(!empty($params2['object_id'])){
            $query->andWhere(['object_id' => $params2['object_id']]);
        }

        return $dataProvider;
    }
}
