# 修复查看页面显示问题

## 任务描述
修复 UserController、RoleController、PermissionController 查看页面的显示问题。

## 已完成的修复

### [✅] 用户管理查看页面 `/admin/users/1`
- **密码显示哈希值** → 已隐藏（`show_show => false` 生效）
- **角色显示原始JSON** → 显示 "Administrator"

### [✅] 角色管理查看页面 `/admin/roles/1`
- **权限显示原始JSON** → 显示 "View Users, Create Users"
- **父级角色显示空白** → 显示 "-"

### [✅] 权限管理 `/admin/permissions`
- **查看页面父级权限显示ID** → 显示 "View Users"
- **列表无树形结构** → 显示空格缩进层级

## 修改的文件

| 文件 | 类型 | 说明 |
|-----|------|------|
| `packages/merlion/src/Http/Controllers/Concerns/HasShow.php:76` | 修改 | `show_detail` → `show_show` |
| `packages/merlion/src/Components/Show/Grid/Relation.php` | 新建 | 处理 belongsToMany 关系显示 |
| `packages/merlion/src/Components/Show/Grid/BelongsTo.php` | 新建 | 处理 belongsTo 关系显示 |
| `packages/merlion/src/Components/Show/Grid/Grid.php` | 修改 | 添加 `belongsToMany`、`treeCheckbox`、`treeSelect` 类型映射 |
| `app/Models/Permission.php` | 修改 | 添加 `flatTree()` 方法 |
| `app/Http/Controllers/Admin/PermissionController.php` | 修改 | 重写 `index` 方法实现树形表格 + 空格缩进 |

## 技术细节

### Relation Grid 组件
处理 belongsToMany 多对多关系，自动提取 `display_name` 或 `name` 属性并用逗号分隔显示。

### BelongsTo Grid 组件
处理 belongsTo 单一关系（如 parent_id），自动从 `_id` 后缀推断关系名称并显示关联模型的名称。

### 树形表格
- `Permission::flatTree()` 返回按父子顺序排列的扁平集合，每个元素包含 `_level` 属性
- `displayValueUsing` 回调根据 `_level` 添加 `&nbsp;` 空格缩进
