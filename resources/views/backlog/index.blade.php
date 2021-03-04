<?php
use App\Http\ViewModels\BackLog\BackLogIndexViewModel;
/* @var  BackLogIndexViewModel $viewModel */
?>

<style>
li{
  list-style-type: none;
  margin: 20px 0;
}

table{
  border-collapse: collapse;
  border-spacing: 0;
  table-layout: fixed;
  width: 490px;
  margin-bottom: 40px;
}

table tr:last-child{
  border-bottom:solid 1px #ddd;
}

table th{
  text-align: center;
  padding: 7px 0;
  border-right:solid 1px #ddd;
  border-left:solid 1px #ddd;
  width: 155px;
}

table th:nth-child(1){
  background-color:#dddddd;
}

table th:nth-child(3){
  background-color:#f5b932;
  color: white;
}

table td{
  text-align: center;
  padding: 7px 0;
  border-right:solid 1px #ddd;
  border-left:solid 1px #ddd;
  width: 155px;
}

table .demo{
  color: #fff;
  background-color: #f34955;
}

table .author{
  color: #fff;
  background-color: #f34955;
}

table .btn_col {
    border-top:solid 1px #ddd;
}

.btn{
  text-decoration: none;
  background-color: #25b327;
  color: white;
  padding:5px 20px;
  border-radius: 5px;
  font-weight: bold;
}

button{
  margin-bottom: 5px;
}

dt{
  width: 400px;
  margin-top: .3em;
  padding: 0 2em;
  color: #FFF;
  background-color: #de8a9d;
}
dd{
  width: 436px;
  padding: 0 1em;
  margin-left: 0;
  font-size: .8em;
  border-width: 0 1px 1px;
  border-style: none solid solid;
  border-color: #de8a9d;
}
</style>

{{-- vue.jsっぽい動きが簡単にできる --}}
<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.0.0/dist/alpine-ie11.js" defer></script>

<div x-data x-init="init()"></div>
<script>
  function init() {
      alert('welcome!');
  };
</script>

@extends("layouts.default")
@section("title", "BackLog Index")
@section("content")
    <h1>Backlog</h1>

    <section>
        <h2>Index</h2>
        <ul>
          <li>
            <a href="/backlog/add-user-story" class="btn">Add User Story</a>
          </li>
          <li>
            <a href="/backlog/add-user-plan" class="btn">Add User Plan</a>
          </li>
        </ul>

        <dl>
          <dt>ID</dt>
          <dd>{{ $viewModel->userInfo->id }}</dd>
          <dt>名前</dt>
          <dd>{{ $viewModel->userInfo->name }}</dd>
          <dt>ストーリー</dt>
          <dd>{{ $viewModel->userInfo->story }}</dd>
          <dt>プラン</dt>
          <dd>{{ $viewModel->userInfo->plan }}</dd>
          <dt>開始日</dt>
          <dd>{{ $viewModel->userInfo->start }}</dd>
          <dt>終了日</dt>
          <dd>{{ $viewModel->userInfo->end }}</dd>
        </dl>

        <div
          aria-labelledby="nav-heading"
          x-data="{ isOpen: false }"
          :aria-expanded="isOpen"
        >
          <button
            :aria-expanded="isOpen"
            aria-controls="nav-list"
            @click="isOpen = !isOpen"
            class="btn"
          >Story</button>

          <table :hidden="!isOpen" id="nav-list">
            <thead>
              <tr>
                  <th>Story</th>
                  <th class="demo"><span class="inner">Demo</th>
                  <th class="author">Estimate</th>
                  <th class="btn_col"></th>
              </tr>
              </thead>
              <tbody>
              @foreach($viewModel->userStories as $story)
                  <tr>
                      <td>{{$story->story}}</td>
                      <td>{{$story->demo}}</td>
                      <td>{{$story->estimation}}</td>
                      <td><a href="/backlog/user-story/{{$story->id}}" class="btn">Detail</td>
                  </tr>
              @endforeach
              </tbody>
          </table>
        </div>

        <div
          aria-labelledby="nav-heading"
          x-data="{ isOpen: false }"
          :aria-expanded="isOpen"
        >
          <button
            :aria-expanded="isOpen"
            aria-controls="nav-list"
            @click="isOpen = !isOpen"
            class="btn"
          >Plan</button>

          <table :hidden="!isOpen" id="nav-list">
            <thead>
            <tr>
                <th>Plan</th>
                <th class="demo"><span class="inner">Start</th>
                <th class="demo"><span class="inner">End</th>
                <th class="author">Estimate</th>
                <th class="btn_col"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($viewModel->userPlans as $plan)
                <tr>
                    <td>{{$plan->plan}}</td>
                    <td>{{$plan->start}}</td>
                    <td>{{$plan->end}}</td>
                    <td>{{$plan->estimation}}</td>
                    <td><a href="/backlog/user-plan/{{$plan->id}}" class="btn">Detail</td>
                </tr>
            @endforeach
            </tbody>
          </table>
        </div>
    </section>
@endsection
