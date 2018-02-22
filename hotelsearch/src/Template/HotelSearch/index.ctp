<?=$this->Html->script('jquery-3.3.1.min') ?>
<?=$this->Html->script('HotelSearch') ?>
<?=$this->Form->create(null, ['type' => 'post','url' => ['controller' => 'HotelSearch','action' => 'index']])?>


<?=$this->Form->input('hotelname',array('label' =>'宿名')) ?>
<label>都道府県</label>
<?=$this->Form->select('prefectures', $prefs, array('id'=>'prefectures','empty' => true))?>
<label>大人人数</label>
<?=$this->Form->select('adult_num', array_combine(range(1, 10),range(1, 10)), array('empty' => true)) ?>
<label>宿泊日数</label>
<?=$this->Form->select('stay_count', array_combine(range(1, 9),range(1, 9)), array('empty' => true)) ?>
<?=$this->Form->submit('検索') ?>
<?=$this->Form->end() ?>
<?=$message ?>
<?=$count ?>

<?php foreach ($hotels as $hotel): ?>
<div>
	<img alt=<?= $hotel->HotelName ?> src=<?= $hotel->PictureURL ?>><br>
  <?= $hotel->HotelName ?><br>
  <?= $hotel->HotelCatchCopy ?><br>
  <?= $hotel->PostCode ?><br>
  <?= $hotel->HotelAddress ?>
  <?php foreach ($hotel->AccessInformation as $access): ?>
  <div>
    <?= $access['name'] ?><br>
    <?= $access ?>
  </div>
  <?php endforeach; ?>


</div>

<?php endforeach; ?>

