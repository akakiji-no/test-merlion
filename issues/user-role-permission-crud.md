# User/Role/Permission CRUD 实现

## 任务描述
基于 Merlion 包实现 User/Role/Permission 的增删改查页面

## 完成状态

### [✅] 数据库
- Migration: roles, permissions, user_has_roles, role_has_permissions
- Models: Role, Permission (含关联方法)
- AdminSeeder: 创建 admin 用户

### [✅] 后台配置
- AdminServiceProvider: 路由 + 菜单导航
- 登录视图修复: 支持动态 username 字段

### [✅] CRUD Controllers
- UserController (含 Password 字段, roles 关联)
- RoleController (含 permissions 关联)
- PermissionController

### [✅] 自定义表单项 (加分项)
- Password 字段: packages/merlion/src/Components/Form/Fields/Password.php
- BelongsToMany 字段: packages/merlion/src/Components/Form/Fields/BelongsToMany.php

### [✅] 修复
- PHP 8.2 兼容性: `const string` → `public const`
- 登录视图: 支持动态 username

## 登录信息
- 用户名: admin
- 密码: 123456

## 访问地址
- 后台: http://127.0.0.1:8000/admin
- 用户管理: http://127.0.0.1:8000/admin/users
- 角色管理: http://127.0.0.1:8000/admin/roles
- 权限管理: http://127.0.0.1:8000/admin/permissions

## 创建/修改的文件

```
app/
├── Models/Role.php
├── Models/Permission.php
├── Providers/AdminServiceProvider.php
└── Http/Controllers/Admin/
    ├── UserController.php
    ├── RoleController.php
    └── PermissionController.php

database/
├── migrations/2025_01_01_000001_create_roles_table.php
├── migrations/2025_01_01_000002_create_permissions_table.php
└── seeders/AdminSeeder.php

packages/merlion/
├── src/Components/Form/Fields/Password.php
├── src/Components/Form/Fields/BelongsToMany.php
├── resources/views/form/fields/password.blade.php
├── resources/views/form/fields/belongs_to_many.blade.php
└── resources/views/auth/login.blade.php (修改)

composer.json (添加 singapura/merlion 依赖)
bootstrap/providers.php (添加 AdminServiceProvider)
```
