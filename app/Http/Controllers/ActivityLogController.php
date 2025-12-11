<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use Yajra\DataTables\DataTables;
use App\Models\User;

class ActivityLogController extends Controller
{
    /**
     * Display a listing of the activity logs.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Activity::with('causer')
                ->orderBy('created_at', 'desc');

            // Apply filters
            if ($request->has('subject_type') && $request->subject_type) {
                $query->where('subject_type', $request->subject_type);
            }

            if ($request->has('event') && $request->event) {
                $query->where('event', $request->event);
            }

            if ($request->has('causer_id') && $request->causer_id) {
                $query->where('causer_id', $request->causer_id);
            }

            if ($request->has('date_from') && $request->date_from) {
                $query->whereDate('created_at', '>=', $request->date_from);
            }

            if ($request->has('date_to') && $request->date_to) {
                $query->whereDate('created_at', '<=', $request->date_to);
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('subject_type_name', function ($activity) {
                    return class_basename($activity->subject_type ?? 'N/A');
                })
                ->addColumn('subject_id', function ($activity) {
                    return $activity->subject_id ?? 'N/A';
                })
                ->addColumn('causer_name', function ($activity) {
                    return $activity->causer ? $activity->causer->name : 'System';
                })
                ->addColumn('event_badge', function ($activity) {
                    $badgeClass = match($activity->event) {
                        'created' => 'bg-success',
                        'updated' => 'bg-info',
                        'deleted' => 'bg-danger',
                        default => 'bg-secondary',
                    };
                    return '<span class="badge ' . $badgeClass . '">' . ucfirst($activity->event) . '</span>';
                })
                ->addColumn('changes', function ($activity) {
                    if ($activity->event === 'updated' && $activity->changes) {
                        $changes = $activity->changes;
                        $oldValues = $changes['old'] ?? [];
                        $newValues = $changes['attributes'] ?? [];
                        
                        $html = '<div class="changes-container">';
                        foreach ($newValues as $key => $newValue) {
                            $oldValue = $oldValues[$key] ?? null;
                            if ($oldValue !== $newValue) {
                                $html .= '<div class="change-item mb-2">';
                                $html .= '<strong>' . ucfirst(str_replace('_', ' ', $key)) . ':</strong><br>';
                                $html .= '<span class="text-danger">' . (is_array($oldValue) ? json_encode($oldValue) : ($oldValue ?? 'null')) . '</span>';
                                $html .= ' → ';
                                $html .= '<span class="text-success">' . (is_array($newValue) ? json_encode($newValue) : ($newValue ?? 'null')) . '</span>';
                                $html .= '</div>';
                            }
                        }
                        $html .= '</div>';
                        return $html;
                    } elseif ($activity->event === 'created' && $activity->changes) {
                        $changes = $activity->changes['attributes'] ?? [];
                        $html = '<div class="changes-container">';
                        foreach ($changes as $key => $value) {
                            $html .= '<div class="change-item mb-1">';
                            $html .= '<strong>' . ucfirst(str_replace('_', ' ', $key)) . ':</strong> ';
                            $html .= '<span class="text-success">' . (is_array($value) ? json_encode($value) : ($value ?? 'null')) . '</span>';
                            $html .= '</div>';
                        }
                        $html .= '</div>';
                        return $html;
                    }
                    return '<span class="text-muted">No changes</span>';
                })
                ->addColumn('created_at_formatted', function ($activity) {
                    return $activity->created_at->format('Y-m-d H:i:s');
                })
                ->addColumn('action', function ($activity) {
                    return '<button class="btn btn-sm btn-info view-details" data-id="' . $activity->id . '" data-bs-toggle="modal" data-bs-target="#activityDetailModal">
                        <i class="ti ti-eye"></i> View Details
                    </button>';
                })
                ->rawColumns(['event_badge', 'changes', 'action'])
                ->make(true);
        }

        // Get filter options
        $subjectTypes = Activity::distinct('subject_type')
            ->whereNotNull('subject_type')
            ->pluck('subject_type')
            ->map(function ($type) {
                return [
                    'value' => $type,
                    'label' => class_basename($type)
                ];
            })
            ->unique('label')
            ->values();

        $users = User::orderBy('name')->get(['id', 'name']);

        return view('activity-logs.index', compact('subjectTypes', 'users'));
    }

    /**
     * Get activity log details
     */
    public function show($id)
    {
        $activity = Activity::with(['causer', 'subject'])->findOrFail($id);
        
        // Format changes for display
        $formattedChanges = [];
        if ($activity->changes) {
            if ($activity->event === 'updated') {
                $oldValues = $activity->changes['old'] ?? [];
                $newValues = $activity->changes['attributes'] ?? [];
                foreach ($newValues as $key => $newValue) {
                    $oldValue = $oldValues[$key] ?? null;
                    if ($oldValue !== $newValue) {
                        $formattedChanges[] = [
                            'field' => ucwords(str_replace('_', ' ', $key)),
                            'old' => $this->formatValue($oldValue),
                            'new' => $this->formatValue($newValue),
                        ];
                    }
                }
            } elseif ($activity->event === 'created') {
                $attributes = $activity->changes['attributes'] ?? [];
                foreach ($attributes as $key => $value) {
                    $formattedChanges[] = [
                        'field' => ucwords(str_replace('_', ' ', $key)),
                        'value' => $this->formatValue($value),
                    ];
                }
            }
        }
        
        return response()->json([
            'status' => 'success',
            'data' => [
                'id' => $activity->id,
                'description' => $activity->description,
                'subject_type' => class_basename($activity->subject_type ?? 'N/A'),
                'subject_id' => $activity->subject_id,
                'event' => $activity->event,
                'causer' => $activity->causer ? $activity->causer->name : 'System',
                'causer_id' => $activity->causer_id,
                'formatted_changes' => $formattedChanges,
                'created_at' => $activity->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $activity->updated_at->format('Y-m-d H:i:s'),
            ]
        ]);
    }

    /**
     * Format value for display
     */
    private function formatValue($value)
    {
        if ($value === null) {
            return '<em class="text-muted">(empty)</em>';
        }
        
        if (is_bool($value)) {
            return $value ? 'Yes' : 'No';
        }
        
        if (is_array($value)) {
            if (empty($value)) {
                return '<em class="text-muted">(empty array)</em>';
            }
            // Format simple arrays
            if (array_keys($value) === range(0, count($value) - 1)) {
                return implode(', ', array_map([$this, 'formatValue'], $value));
            }
            // Format associative arrays
            $formatted = [];
            foreach ($value as $k => $v) {
                $formatted[] = ucwords(str_replace('_', ' ', $k)) . ': ' . $this->formatValue($v);
            }
            return implode(', ', $formatted);
        }
        
        if (is_object($value)) {
            return json_encode($value, JSON_PRETTY_PRINT);
        }
        
        // Truncate long strings
        $stringValue = (string) $value;
        if (strlen($stringValue) > 100) {
            return substr($stringValue, 0, 100) . '...';
        }
        
        return $stringValue;
    }
}
