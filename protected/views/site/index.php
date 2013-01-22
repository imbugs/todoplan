<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>
<script id="tmpl-task-item" type="text/x-jquery-tmpl">
<li class="task-item" rel="${id}">
	<a href="#task/${id}" class="item-title" data-target="#item_content_${id}">
		<span class="add-on task-checkbox">
			<i class="icon ${icon}"></i>
		</span>
		<span class="title">${title}</span>
		<span class="holder"></span>
		<span class="task-edit-title opacity75">
			<i class="icon-collapse icon-chevron-down"></i>
			<i class="icon-edit"></i>
			<i class="icon-remove"></i>
		</span>
	</a>
	<div id="item_content_${id}" class="collapse ">
		<div class="item-detail note">
			<textarea class='expanding' placeholder="输入任务描述...">${content}</textarea>
		</div>
	</div>
</li>
</script>
<script id="tmpl-list-item" type="text/x-jquery-tmpl">
<li class="task-list ${delableClass} droppable" rel="${id}">
	<a href="#list/${id}" class="noeditor">
		<i class="${icon}"></i>
		<span class="title">${list_title}</span>
	</a>
</li>
</script>
<script id="tmpl-list-update" type="text/x-jquery-tmpl">
<a href="#list/${id}/edit" class="editor" style="height: 31px; line-height: 31px; padding-top: 0px; padding-bottom: 0px">
	<i class="icon-chevron-right editor"></i>
	<input type="text" name="updateList" id="updateList" maxlength="63" class="input-small update editor"
		placeholder="新名称..." oldvalue="${title}" value="${title}">
</a>
</script>
<script id="tmpl-input-editor" type="text/x-jquery-tmpl">
<span class="input-container">
	<input type="text" name="input-update" id="input-update" maxlength="63" class="${size} update editor"
		placeholder="新名称..." oldvalue="${title}" value="${title}">
</span>
</script>
<script id="tmpl-confirm-modal" type="text/x-jquery-tmpl">
<div class="modal hide fade confirm">
	<div class="modal-body">
		<h3>${message}</h3>
	</div>
	<div class="modal-footer">
		<p class="text-error" style="float:left; padding: 0; margin: 0; font-style: italic;">此操作不可恢复</p>
		<a href="#" class="btn cancel">取消</a>
		<a href="#" class="btn btn-primary confirm">删除</a>
	</div>
</div>
</script>
<script type="text/javascript">
<!--
//-->
</script>
<style>
<!--
-->
</style>
<div class="container-fluid height100">
	<div class="row-fluid height100">
		<div class="lists span3">
			<div id="toolbar">
				<div class="dropdown">
					<a href="#/me" id="user" class="dropdown-toggle" data-toggle="dropdown" data-target="#">
						<span></span>
						<img class="avatar" src="<?php echo Yii::app()->request->baseUrl; ?>/dist/app/images/users/32.png"/>
					</a>
					<ul class="dropdown-menu" role="menu">
						<li>
							<a tabindex="-1" href="#settings" data-toggle="modal">设置</a>
						</li>
                        <li class="divider"></li>
                        <li><a tabindex="-1" href="<?php echo Config::getUrl('logoutUrl');?>">退出</a></li>
                    </ul>
				</div>
				<div id="logo">
					<a href="<?php echo Yii::app()->homeUrl;?>" class="button">
						<span class="logo">
							<img src="<?php echo Config::getInstance()->logo ?>">
						</span>
					</a>
				</div>
				<div class="search-container" style="display: none;">
					<input type="text" class="input-small search-query search-item" placeholder="查找任务...">
				</div>
				<a href="#/search" id="search" class="search">
					<i class="icon-search"></i>
				</a>
			</div>
			<div id="scrollable-list" class="scrollable">
					<div class="scroller" style="padding: 5px 0px 10px 0px;">
						<ul class="task_lists nav nav-pills nav-stacked list-sortable">
				        </ul>
				        <ul class="nav nav-pills nav-stacked">
					        <li class="add-list">
								<a href="#list/new" style="height: 31px; line-height: 31px; padding-top: 0px; padding-bottom: 0px">
									<i class="icon-plus"></i>
									<span id="add-list-label">添加新列表</span>
									<span class="holder">
										<input type="text" name="addList" id="addList"  maxlength="63" class="input-small update" placeholder="添加新列表..." style="display: none;">
									</span>
								</a>
							</li>
				        </ul>
			        </div>
		        </div>
	        <div id="sidebar-actions" class="span3">
	        	<a class="delete">
	        		<span class="icon detail-trash"></span>
	        	</a>
	        	<a class="settings">
	        		<span class="icon settings" style="float: right; margin-right: 20px;"></span>
	        	</a>
	        </div>
		</div>
		<div style="width: 1px; background-color: gray; float: left" class="height100"></div>
		<div class="tasks span8 height100">
			<div class="add-tasks area">
				<ul class="task-items nav nav-tabs nav-stacked ">
					<li id="input-width">
						<input type="text" name="addItem" id="addItem" maxlength="255" class="input-xxlarge" placeholder="添加一个任务...">
					</li>
				</ul>
			</div>
			<div id="scrollable-item" class="scrollable">
				<div class="scroller">
					<div class="area">
						<h3 class="heading">
							<text rel="label_tasks_heading">
								<i class="icon-list"></i>
								<span id="label_list_title" style="padding-left: 10px;"></span>
							</text>
						</h3>
						<ul class="todo-tasks task-items nav nav-tabs nav-stacked task-sortable">
						</ul>
					</div>
					<div class="recently-completed area" style="padding: 5px 0px 10px 0px;">
						<h3 class="heading completed" style="display: none;">
							<text rel="label_completed_tasks_heading">
								<i class="icon-list"></i>
								<span style="padding-left: 10px;">最近完成</span>
							</text>
						</h3>
						<ul class="done-tasks task-items nav nav-tabs nav-stacked opacity80">
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div id="settings" class="modal hide fade">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h3>设置</h3>
		</div>
		<div class="modal-body">
			<ul class="nav nav-tabs">
				<li class="active"><a href="#profiles" data-toggle="tab">个人信息</a></li>
				<li><a href="#changepasswd" data-toggle="tab">修改密码</a></li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane active" id="profiles">
					<div class="form-horizontal">
					    <div class="control-group">
					        <div class="info-label">用户名</div>
					        <div class="controls">
					        	<?php echo $userInfo->username;?>
					        </div>
					    </div>
					    <div class="control-group">
					        <div class="info-label">电子邮件</div>
					        <div class="controls">
					        	<?php echo $userInfo->email;?>
					        </div>
					    </div>
					</div>
				</div>
				<div class="tab-pane" id="changepasswd">
					<div class="tab-inner">
						<div id="change-result" class="warning"></div>
						<form class="form-horizontal" data-async action="?r=user/changepasswd" data-target="#change-result" method="post">
						    <input type="hidden" name="username" value="<?php echo $userInfo->username;?>">
						    <div class="control-group">
						        <label class="control-label" for="currentPasswd">当前密码</label>
						        <div class="controls">
						        	<input type="password" id="currentPasswd" name="currentPasswd" placeholder="当前密码">
						        </div>
						    </div>
						    <div class="control-group">
						        <label class="control-label" for="newPasswd">新密码</label>
						        <div class="controls">
						        	<input type="password" id="newPasswd" name="newPasswd" placeholder="新密码">
						        </div>
						    </div>
						    <div class="control-group">
						        <label class="control-label" for="verifyPasswd">确认密码</label>
						        <div class="controls">
						        	<input type="password" id="verifyPasswd" name="verifyPasswd" placeholder="确认密码">
						        </div>
						    </div>
						    <div class="control-group">
						   		<div class="controls">
							    	<button id="changePassword" type="submit" class="btn btn-primary">保存</button>
							    	<span style="margin-left: 100px;">
										<a href="<?php echo Config::getUrl('forgetUrl');?>" class="default">忘记密码？</a>
									</span>
							    </div>
						    </div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<a href="#" class="btn" onclick="javascript:window.TP.app.closeSettings();">关闭</a>
		</div>
	</div>
</div>

