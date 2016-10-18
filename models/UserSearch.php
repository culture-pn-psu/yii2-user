<?php

namespace culturePnPsu\user\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use culturePnPsu\user\models\User;
use culturePnPsu\user\models\Profile;
use mdm\admin\models\Assignment;

/**
 * UserSearch represents the model behind the search form about `culturePnPsu\user\models\User`.
 */
class UserSearch extends User
{
    private $profileAttr = [
        'profile.firstname', 
        'profile.lastname', 
        'profile.fullname'
    ];
    /**
     * @inheritdoc
     */

    public function attributes()
    {
        // add related fields to searchable attributes
      return array_merge(parent::attributes(), $this->profileAttr);

    }


    public function rules()
    {
        return [
            [['id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['username', 'auth_key', 'password_hash', 'password_reset_token', 'email',], 'safe'],

            [$this->profileAttr, 'safe'],
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
        $query = User::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=>[
                'defaultOrder'=>['id'=> SORT_DESC],
            ],
        ]);

        $dataProvider->sort->attributes['profile.fullname'] = [
            'asc' => [Profile::tableName().'.firstname' => SORT_ASC],
            'desc' => [Profile::tableName().'.firstname' => SORT_DESC],
        ];
        $query->joinWith(['profile']);  
        
        
        $query = $this->queryPermissiton($query);
        
        
        
        

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'auth_key', $this->auth_key])
            ->andFilterWhere(['like', 'password_hash', $this->password_hash])
            ->andFilterWhere(['like', 'password_reset_token', $this->password_reset_token])
            ->andFilterWhere(['like', 'email', $this->email]);

        $query->andFilterWhere(['like', Profile::tableName().'.firstname', $this->getAttribute('profile.fullname')])
            ->orFilterWhere(['like', Profile::tableName().'.lastname', $this->getAttribute('profile.fullname')]);

        return $dataProvider;
    }
    
    public function queryPermissiton($query){
        if(Yii::$app->user->can('admin')){
            //$query->join('LEFT JOIN','auth_assignment','auth_assignment.user_id = user.id');  
            //$query->where(['auth_assignment.item_name'=>['staff','user']]);
        }elseif(Yii::$app->user->can('staffUser')||Yii::$app->user->can('boss')){
            $query->join('LEFT JOIN','auth_assignment','auth_assignment.user_id = user.id');  
            $query->where(['auth_assignment.item_name'=>['staff','user']]);
        }elseif(Yii::$app->user->can('staff')){
            $query->join('LEFT JOIN','auth_assignment','auth_assignment.user_id = user.id');  
            $query->where(['auth_assignment.item_name'=>'user']);
        }
        
        return $query;        
    }
    
}
