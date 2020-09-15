SET FOREIGN_KEY_CHECKS = 0;

create table if not exists cy_mode_MODULE_ID
(
    `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id',
    `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL COMMENT '模块名称',
    `type` tinyint(4) NULL DEFAULT 1,
    `display` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL COMMENT '展示方式',
    `status` tinyint(4) NULL DEFAULT NULL COMMENT '模块状态',
    `ctime` int(11) NULL DEFAULT NULL,
    `mtime` int(11) NULL DEFAULT NULL,
    PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci COMMENT = '模块表' ROW_FORMAT = Dynamic;


create table if not exists cy_mode_point_MODULE_ID
(
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `mode_id` int(11) NULL DEFAULT NULL COMMENT '模块id',
    `point_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL COMMENT '埋点id',
    `step` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL COMMENT '步骤',
    `ctime` int(11) NULL DEFAULT NULL,
    `mtime` int(11) NULL DEFAULT NULL,
    PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci COMMENT = '模块埋点对应表' ROW_FORMAT = Dynamic;



create table if not exists cy_hide_point_MODULE_ID
(
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `point_page` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL COMMENT '埋点页面',
    `event_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL COMMENT '埋点名称',
    `event_act` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL COMMENT '埋点行为',
    `status` tinyint(4) NULL DEFAULT 0,
    `ctime` int(11) NULL DEFAULT NULL,
    `mtime` int(11) NULL DEFAULT NULL,
    PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci COMMENT = '埋点表' ROW_FORMAT = Dynamic;


create table if not exists cy_view_user_MODULE_ID
(
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `point_id` int(11) NULL DEFAULT NULL COMMENT '埋点id',
    `view_user_id` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL COMMENT '用户id',
    `day` int(11) NULL DEFAULT NULL COMMENT '时间精确到小时',
    `ctime` int(11) NULL DEFAULT NULL COMMENT '创建时间',
    `mtime` int(11) NULL DEFAULT NULL COMMENT '更新时间',
    PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Dynamic;


create table if not exists cy_static_data_MODULE_ID
(
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `point_id` int(11) NULL DEFAULT NULL COMMENT '埋点id',
    `account` int(11) NULL DEFAULT NULL COMMENT '统计数量',
    `day` int(11) NULL DEFAULT NULL COMMENT '统计时间',
    PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Dynamic;

create table if not exists cy_module_MODULE_ID
(
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL COMMENT '行为名称\n',
    `remark` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL COMMENT '描述',
    `template` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL COMMENT '模板',
    `modes` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL COMMENT '行为包含模块',
    `status` tinyint(4) NULL DEFAULT 1 COMMENT '状态',
    `ctime` int(11) NULL DEFAULT NULL,
    `mtime` int(11) NULL DEFAULT NULL,
    `parent_id` int(11) NULL DEFAULT NULL COMMENT '父节点',
    PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Dynamic;
SET FOREIGN_KEY_CHECKS = 1;

insert into statics.cy_module_MODULE_ID (id, name, remark, template, modes, status, ctime, mtime, parent_id)
values (1, '关键行为', null, null, null, 1, null, null, null);
insert into statics.cy_module_MODULE_ID (id, name, remark, template, modes, status, ctime, mtime, parent_id)
values (2, '其他操作', null, null, null, 1, null, null, null);
insert into statics.cy_module_MODULE_ID (id, name, remark, template, modes, status, ctime, mtime, parent_id)
values (3, '分享分析', null, null, null, 1, null, null, null);
insert into statics.cy_module_MODULE_ID (id, name, remark, template, modes, status, ctime, mtime, parent_id)
values (4, '设备属性', null, null, null, 1, null, null, null);





