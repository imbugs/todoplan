<?php
interface UserConstant {
	// 初始状态
	const STATUS_INIT = "tovalid";
	// 等待验证email
	const STATUS_TOVALID = "tovalid";
	// 激活用户
	const STATUS_ACTIVE = "active";
	
	// 本地注册
	const TYPE_LOCAL = "local";
	// 本地注册
	const TYPE_WEIBO = "weibo";
	// 本地注册
	const TYPE_QQ = "qq";
	
	// 校验Email
	const VERIFY_VALID = "valid";
	// 重置密码
	const VERIFY_RESET = "reset";
}
