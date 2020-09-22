/*
 Navicat Premium Data Transfer

 Source Server         : 127.0.0.1
 Source Server Type    : MySQL
 Source Server Version : 50726
 Source Host           : localhost:3306
 Source Schema         : statics

 Target Server Type    : MySQL
 Target Server Version : 50726
 File Encoding         : 65001

 Date: 21/09/2020 09:51:20
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for cy_hide_point
-- ----------------------------
DROP TABLE IF EXISTS `cy_hide_point_MODULE_ID`;
CREATE TABLE `cy_hide_point_MODULE_ID`
(
    `id`          int(11)                                                 NOT NULL AUTO_INCREMENT,
    `platform`    tinyint(1)                                              NULL     DEFAULT NULL COMMENT '平台\r\n\r\n1,pc端网页\r\n2,手机端网页\r\n3,ios\r\n4,安卓\r\n5,小程序',
    `page`        varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL     DEFAULT NULL COMMENT '埋点页面',
    `name`        varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL     DEFAULT NULL COMMENT '埋点名称',
    `image`       varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL     DEFAULT NULL COMMENT '埋点图片\r\n',
    `use_state`   text CHARACTER SET utf8 COLLATE utf8_unicode_ci         NULL COMMENT '使用状态，关联行为',
    `point_state` tinyint(1)                                              NOT NULL DEFAULT 2 COMMENT '是否埋点，1已埋点2未埋点，\r\n默认2',
    `status`      tinyint(4)                                              NOT NULL DEFAULT 1 COMMENT '埋点状态1是正常，2删除，\r\n默认1',
    `ctime`       int(11)                                                 NULL     DEFAULT NULL,
    `mtime`       int(11)                                                 NULL     DEFAULT NULL,
    PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB
  AUTO_INCREMENT = 1000
  CHARACTER SET = utf8
  COLLATE = utf8_unicode_ci COMMENT = '埋点表'
  ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cy_hide_point
-- ----------------------------

-- ----------------------------
-- Table structure for cy_mode
-- ----------------------------
DROP TABLE IF EXISTS `cy_mode_MODULE_ID`;
CREATE TABLE `cy_mode_MODULE_ID`
(
    `id`      int(11)                                                 NOT NULL AUTO_INCREMENT COMMENT '自增id',
    `name`    varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL COMMENT '模块名称',
    `type`    tinyint(4)                                              NULL DEFAULT 1,
    `display` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL COMMENT '展示方式',
    `status`  tinyint(4)                                              NULL DEFAULT NULL COMMENT '模块状态',
    `ctime`   int(11)                                                 NULL DEFAULT NULL,
    `mtime`   int(11)                                                 NULL DEFAULT NULL,
    PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB
  AUTO_INCREMENT = 1
  CHARACTER SET = utf8
  COLLATE = utf8_unicode_ci COMMENT = '模块表'
  ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cy_mode
-- ----------------------------

-- ----------------------------
-- Table structure for cy_mode_point
-- ----------------------------
DROP TABLE IF EXISTS `cy_mode_point_MODULE_ID`;
CREATE TABLE `cy_mode_point_MODULE_ID`
(
    `id`       int(11)                                                 NOT NULL AUTO_INCREMENT,
    `mode_id`  int(11)                                                 NULL DEFAULT NULL COMMENT '模块id',
    `point_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL COMMENT '埋点id',
    `step`     varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL COMMENT '步骤',
    `ctime`    int(11)                                                 NULL DEFAULT NULL,
    `mtime`    int(11)                                                 NULL DEFAULT NULL,
    PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB
  AUTO_INCREMENT = 1
  CHARACTER SET = utf8
  COLLATE = utf8_unicode_ci COMMENT = '模块埋点对应表'
  ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cy_mode_point
-- ----------------------------

-- ----------------------------
-- Table structure for cy_module
-- ----------------------------
DROP TABLE IF EXISTS `cy_module_MODULE_ID`;
CREATE TABLE `cy_module_MODULE_ID`
(
    `id`        int(11)                                                 NOT NULL AUTO_INCREMENT,
    `name`      varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL COMMENT '行为名称\n',
    `parent_id` int(11)                                                 NULL DEFAULT NULL COMMENT '父节点',
    `remark`    varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL COMMENT '描述',
    `modes`     varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL COMMENT '行为包含模块',
    `status`    tinyint(4)                                              NULL DEFAULT 1 COMMENT '状态',
    `ctime`     int(11)                                                 NULL DEFAULT NULL,
    `mtime`     int(11)                                                 NULL DEFAULT NULL,
    PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB
  AUTO_INCREMENT = 5
  CHARACTER SET = utf8
  COLLATE = utf8_unicode_ci
  ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cy_module
-- ----------------------------
INSERT INTO `cy_module_MODULE_ID`
VALUES (1, '关键行为', NULL, NULL, NULL, 1, NULL, NULL);
INSERT INTO `cy_module_MODULE_ID`
VALUES (2, '其他操作', NULL, NULL, NULL, 1, NULL, NULL);
INSERT INTO `cy_module_MODULE_ID`
VALUES (3, '分享分析', NULL, NULL, NULL, 1, NULL, NULL);
INSERT INTO `cy_module_MODULE_ID`
VALUES (4, '设备属性', NULL, NULL, NULL, 1, NULL, NULL);

-- -----------
-- Table structure for cy_static_area
-- ----------------------------
DROP TABLE IF EXISTS `cy_static_area_MODULE_ID`;
CREATE TABLE `cy_static_area_MODULE_ID`
(
    `id`       int(11)                                                 NOT NULL AUTO_INCREMENT COMMENT 'Id',
    `province` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL COMMENT '省',
    `platform` tinyint(1)                                              NULL DEFAULT NULL COMMENT '平台\r\n\r\n1,pc端网页\r\n2,手机端网页\r\n3,ios\r\n4,安卓\r\n5,小程序',
    `city`     varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL COMMENT '市',
    `account`  int(11)                                                 NULL DEFAULT NULL COMMENT '数量',
    `day`      int(11)                                                 NULL DEFAULT NULL COMMENT '日期',
    `hour`     int(11)                                                 NULL DEFAULT NULL COMMENT '时间',
    PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB
  AUTO_INCREMENT = 1
  CHARACTER SET = utf8
  COLLATE = utf8_unicode_ci COMMENT = '地域统计表'
  ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cy_static_area
-- ----------------------------

-- ----------------------------
-- Table structure for cy_static_data
-- ----------------------------
DROP TABLE IF EXISTS `cy_static_data_MODULE_ID`;
CREATE TABLE `cy_static_data_MODULE_ID`
(
    `id`       int(11)    NOT NULL AUTO_INCREMENT,
    `point_id` int(11)    NULL DEFAULT NULL COMMENT '埋点id',
    `account`  int(11)    NULL DEFAULT NULL COMMENT '统计数量',
    `platform` tinyint(1) NULL DEFAULT NULL COMMENT '平台\r\n\r\n1,pc端网页\r\n2,手机端网页\r\n3,ios\r\n4,安卓\r\n5,小程序',
    `day`      int(11)    NULL DEFAULT NULL COMMENT '日期',
    `hour`     int(11)    NULL DEFAULT NULL COMMENT '时间',
    `expoint`  int(11)    NULL DEFAULT NULL COMMENT '入口埋点',
    PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB
  AUTO_INCREMENT = 1
  CHARACTER SET = utf8
  COLLATE = utf8_unicode_ci
  ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cy_static_data
-- ----------------------------

-- ----------------------------
-- Table structure for cy_static_device
-- ----------------------------
DROP TABLE IF EXISTS `cy_static_device_MODULE_ID`;
CREATE TABLE `cy_static_device_MODULE_ID`
(
    `id`             int(11)                                                 NOT NULL AUTO_INCREMENT COMMENT 'ID',
    `platform`       tinyint(1)                                              NULL DEFAULT NULL COMMENT '平台类型：\r\n1,pc端网页\r\n2,手机端网页\r\n3,ios\r\n4,安卓\r\n5,小程序',
    `device_name`    varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL COMMENT '设备名称',
    `device_type`    varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL COMMENT '设备类型',
    `device_brand`   varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL COMMENT '设备厂商',
    `device_version` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL COMMENT '版本号',
    `account`        int(11)                                                 NULL DEFAULT NULL COMMENT '统计数量',
    `day`            int(11)                                                 NULL DEFAULT NULL COMMENT '日期',
    `hour`           int(11)                                                 NULL DEFAULT NULL COMMENT '时间',
    PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB
  AUTO_INCREMENT = 1
  CHARACTER SET = utf8
  COLLATE = utf8_unicode_ci COMMENT = '设备统计表'
  ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cy_static_device
-- ----------------------------

-- ----------------------------
-- Table structure for cy_view_user
-- ----------------------------
DROP TABLE IF EXISTS `cy_view_user_MODULE_ID`;
CREATE TABLE `cy_view_user_MODULE_ID`
(
    `id`             int(11)                                                 NOT NULL AUTO_INCREMENT,
    `point_id`       int(11)                                                 NULL DEFAULT NULL COMMENT '埋点id',
    `view_user_id`   varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci  NULL DEFAULT NULL COMMENT '用户id',
    `day`            int(11)                                                 NULL DEFAULT NULL COMMENT '日期',
    `platform`       tinyint(1)                                              NULL DEFAULT NULL COMMENT '平台\r\n\r\n1,pc端网页\r\n2,手机端网页\r\n3,ios\r\n4,安卓\r\n5,小程序',
    `hour`           int(11)                                                 NULL DEFAULT NULL COMMENT '时间',
    `ctime`          int(11)                                                 NULL DEFAULT NULL COMMENT '创建时间',
    `mtime`          int(11)                                                 NULL DEFAULT NULL COMMENT '更新时间',
    `device_name`    varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL COMMENT '设备名称',
    `device_type`    varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL COMMENT ' 设备型号',
    `device_version` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL COMMENT '版本号',
    `device_brand`   varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL COMMENT '设备厂商',
    `province`       varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci  NULL DEFAULT NULL COMMENT '省',
    `city`           varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci  NULL DEFAULT NULL COMMENT '市',
    PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB
  AUTO_INCREMENT = 1
  CHARACTER SET = utf8
  COLLATE = utf8_unicode_ci
  ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cy_view_user
-- ----------------------------

SET FOREIGN_KEY_CHECKS = 1;
