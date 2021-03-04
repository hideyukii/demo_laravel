@extends("layouts.default")
@section("title", "BackLog AddUserPlan")
@section("content")

<style>
.radio {
	text-align: left;
}

.radio input[type="radio"] + span {
	display: inline-block;
	position: relative;
	padding: 0 0 0 1.2em;
	margin: 0 .2em 0;
	cursor: pointer;
}
.radio input[type="radio"] + span::before {
	position: absolute;
	content: "";
	top: 50%;
	left: 0;
	transform: translateY(-50%);
	background: #fff;
	border: 1px solid rgba(0,0,0,.1);
	border-radius: 50%;
	width: 1em;
	height: 1em;
	display: block;
}
.radio input[type="radio"]:checked + span::after {
	position: absolute;
	content: "";
	top: 50%;
	left: 0;
	transform: translateY(-50%);
	background: #F44336;
	border-radius: 50%;
	width: 1em;
	height: 1em;
	border: .2em solid #fff;
	display: block;
}
</style>

<h1>Backlog</h1>
<h2>AddUserPlan</h2>

<form action="/backlog/add-user-plan" method="post">
    {{csrf_field()}}

    <h4>契約プラン</h4>
    <div class="container">
        <div class="radio">
          <input id="plan-1" name="plan" type="radio" value="ライト" checked>
          <label for="radio-1" class="radio-label">ライトプラン</label>
        </div>
      
        <div class="radio">
          <input id="plan-2" name="plan" type="radio" value="スタンダード">
          <label  for="radio-2" class="radio-label">スタンダードプラン
          </label>
        </div>
      
        <div class="radio">
          <input id="plan-3" name="plan" type="radio" value="ヘビー">
          <label for="radio-3" class="radio-label">ヘビープラン</label>
        </div>
    </div>

    <h4>契約年数</h4>
    <div class="container">
        <div class="radio">
          <input id="month-1" name="month" type="radio" value="12" checked>
          <label for="radio-1" class="radio-label">1年</label>
        </div>
      
        <div class="radio">
          <input id="month-2" name="month" type="radio"  value="36">
          <label for="radio-2" class="radio-label">3年</label>
        </div>
      
        <div class="radio">
          <input id="month-3" name="month" type="radio" value="60">
          <label for="radio-3" class="radio-label">5年</label>
        </div>
    </div>

    <button type="submit">Submit</button>
</form>

@endsection
