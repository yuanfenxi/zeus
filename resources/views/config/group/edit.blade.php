@extends('layouts.app')
@section('content')
<form class="form-horizontal" role="form" method="POST" action="{{ route('group-post-edit',['id'=>$group->id]) }}">
    {{ csrf_field() }}

     <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
             <label for="name" class="col-md-4 control-label right-label"><div>name:</div></label>
             <div class="col-md-6">
                 <input id="name" type="text" class="form-control" name="name" value="{{ $group->name }}">
                 @if ($errors->has('name'))
                 <span class="help-block">
                      <strong>{{ $errors->first('name') }}</strong>
                 </span>
                 @endif
             </div>
         </div>



  <div class="form-group{{ $errors->has('codeBase') ? ' has-error' : '' }}">
          <label for="codeBase" class="col-md-4 control-label right-label"><div>codeBase:</div></label>
          <div class="col-md-6">
              <input id="codeBase" type="text" class="form-control" name="codeBase" value="{{ $group->codeBase }}">
              @if ($errors->has('codeBase'))
              <span class="help-block">
                   <strong>{{ $errors->first('codeBase') }}</strong>
              </span>
              @endif
          </div>
      </div>

     <div class="form-group{{ $errors->has('deployPath') ? ' has-error' : '' }}">
             <label for="deployPath" class="col-md-4 control-label right-label"><div>deployPath:</div></label>
             <div class="col-md-6">
                 <input id="deployPath" type="text" class="form-control" name="deployPath" value="{{ $group->deployPath }}">
                 @if ($errors->has('deployPath'))
                 <span class="help-block">
                      <strong>{{ $errors->first('deployPath') }}</strong>
                 </span>
                 @endif
             </div>
         </div>


    <div class="form-group">
        <div class="col-md-6 col-md-offset-4">
            <button type="submit" class="btn btn-primary">提交</button>
        </div>
    </div>
</form>
@endsection