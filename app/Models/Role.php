<?php

namespace App\Models;

use Spatie\Permission\Models\Role as Model;

/**
 * App\Models\Role.
 *
 * @property int                                                               $id
 * @property string                                                            $name
 * @property string                                                            $guard_name
 * @property string|null                                                       $description
 * @property int                                                               $is_build_in
 * @property \Illuminate\Support\Carbon|null                                   $created_at
 * @property \Illuminate\Support\Carbon|null                                   $updated_at
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\Permission[] $permissions
 * @property int|null                                                          $permissions_count
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\User[]       $users
 * @property int|null                                                          $users_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|Role query()
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereGuardName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereIsBuildIn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Role extends Model
{
}
