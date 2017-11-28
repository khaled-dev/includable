<?php

namespace KhaledDev\Includable;


trait Includable
{
    /**
     * load resources by the relations name.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithRequestIncludes($query)
    {
        $fields = $this->includable ?? [];

        $request = request('includes');

        foreach ($fields as $field) {
            if (in_array($field, explode(',', $request))) {
                $query = $query->with($field);
            }
        }

        return $query;
    }

    /**
     * load a specific resource by the relation's name.
     *
     * @return $this
     */
    public function loadRequestIncludes()
    {
        $fields = $this->includable ?? [];

        $request = request('includes');

        foreach ($fields as $field) {
            if (in_array($field, explode(',', $request))) {
                $this->load($field);
            }
        }

        return $this;
    }

    /**
     * To get the loaded relation.
     *
     * @param string $relation
     * @return $this
     */
    public function loaded(string $relation)
    {
        $fields = $this->includable ?? [];

        $request = request('includes');

        foreach ($fields as $field) {
            if (in_array($field, explode(',', $request))) {
                if (strcasecmp($relation, $field) == 0) {
                    return $this->$relation;
                }
            }
        }

        return null;
    }
}
